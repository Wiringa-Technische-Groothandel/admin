<?php

namespace WTG\Admin\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Barryvdh\Snappy\PdfWrapper;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Illuminate\Support\Facades\File;
use WTG\Catalog\Interfaces\ProductInterface as Product;
use WTG\Content\Interfaces\ContentInterface as Content;

/**
 * Export controller.
 *
 * @package     WTG\Admin
 * @subpackage  Controllers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ExportController extends Controller
{
    /**
     * Catalog generation page.
     *
     * @param  Content  $content
     * @return \Illuminate\View\View
     */
    public function view(Content $content)
    {
        $catalogFooter = $content->tag('admin.catalog_footer')->first();

        return view('admin::export.index', compact('catalogFooter'));
    }

    /**
     * Generate the catalog PDF file.
     *
     * @param  Request  $request
     * @param  Content  $content
     * @param  Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function catalog(Request $request, Content $content, Product $product)
    {
        $footer = $content->tag('admin.catalog_footer')->first();

        if ($request->input('footer') !== '') {
            /** @var Content $footer */
            $footer->setValue($request->input('footer'));
            $footer->save();
        }

        ini_set('memory_limit', '1G');

        $publicFilename = "dl/Wiringa Catalogus.pdf";
        $filename = 'catalog-'.date('YmdHis').'.pdf';
        $storagePath = storage_path('app/public/'.$filename);
        $publicPath = public_path($publicFilename);
        /** @var Collection $products */
        $products = $product
            ->orderBy('catalog_group', 'asc')
            ->orderBy('group', 'asc')
            ->orderBy('type', 'asc')
            ->orderBy('sku', 'asc')
            ->whereNotIn('action_type', ['Opruiming', 'Actie'])
            ->where('catalog_index', '!=', '')
            ->get();

        $products = $products
            ->groupBy('catalog_group')
            ->map(function ($products, $group) {
                return $products
                    ->groupBy('series')
                    ->map(function ($products, $series) {
                        return $products->groupBy('type');
                    });
            });

        /** @var PdfWrapper $pdf */
        $pdf = PDF::loadHTML(view('admin::export.templates.catalog', compact('products'))->render());
        $pdf->setPaper('a4')
            ->setOrientation('portrait')
            ->setOption('footer-center', $footer->getValue())
            ->setOption('footer-right', "[page]")
            ->setOption('footer-font-size', 7)
            ->setOption('toc', true)
            ->setOption('xsl-style-sheet', base_path('resources/assets/catalog-stylesheet.xsl'))
            ->save($storagePath);

        if (File::exists($publicPath)) {
            File::delete($publicPath);
        }

        File::link($storagePath, $publicPath);

        return redirect($publicFilename);
    }

    /**
     * Generate a pricelist for a specific user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function pricelist(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'user_id'   => 'required',
            'separator' => 'required',
            'position'  => 'required',
        ]);

        if (! $validator->fails() && $request->hasFile('file')) {
            $user_id = $request->input('user_id');
            $file = $request->file('file');
            $separator = $request->input('separator');
            $position = $request->input('position');
            $skip = (int) $request->input('skip');
            $count = 0;

            // Create a filesystem link to the temp file
            $filename = storage_path().'/prijslijst_'.$user_id.'.txt';

            // Store the path in flash data so the middleware can delete the file afterwards
            \Session::flash('file.download', $filename);

            $string = "product;netto prijs;prijs per;registratie eenheid\r\n";

            foreach (file($file->getRealPath()) as $input) {
                if ($count >= $skip) {
                    $linedata = str_getcsv($input, $separator);

                    if (isset($linedata[$position - 1])) {
                        $product = Product::select(['number', 'group', 'price', 'refactor', 'price_per', 'special_price', 'registered_per'])
                            ->where('number', $linedata[$position - 1])
                            ->first();

                        if ($product !== null) {
                            if ($product->special_price === '0.00') {
                                $discount = 1 - (app('helper')->getProductDiscount($user_id, $product->group, $product->number) / 100);
                                $price = number_format(preg_replace("/\,/", '.', $product->price) * $discount, 2, ',', '');
                            } else {
                                $price = number_format(preg_replace("/\,/", '.', $product->special_price), 2, ',', '');
                            }

                            $string .= $product->number.';'.$price.';'.$product->price_per.';'.$product->registered_per."\r\n";
                        }
                    }
                }

                $count++;
            }

            // File the file with discount data
            File::put($filename, $string);

            // Return the data as a downloadable file: 'icc_data.txt'
            return response()
                ->download($filename, 'prijslijst_'.$user_id.'.txt');
        } else {
            return redirect('admin/generate')
                ->withErrors(($request->hasFile('file') === false ? 'Geen bestand geuploaded' : $validator->errors()))
                ->withInput($request->input());
        }
    }
}

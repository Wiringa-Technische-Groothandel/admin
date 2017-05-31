<?php

namespace WTG\Admin\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use WTG\Content\Interfaces\ContentInterface as Content;

/**
 * Import controller.
 *
 * @package     WTG\Admin
 * @subpackage  Controllers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ImportController extends Controller
{
    /**
     * The import page.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        return view('admin::import.index');
    }

    /**
     * Product import handler.
     *
     * @param  Request  $request
     * @param  Content  $content
     * @return \Illuminate\Http\RedirectResponse
     */
    public function product(Request $request, Content $content)
    {
        if ($request->hasFile('productFile')) {
            $file = $request->file('productFile');

            $file->move(storage_path().'/import', 'products.csv');

            $runTime = Carbon::now('Europe/Amsterdam');
            $runTime->setTimestamp(strtotime('+'.time_to_next_import().' minutes'));

            $content->tag('admin.product_import')->update([
                'content'    => 'Er is een import ingepland voor '.$runTime->format('H:i'),
                'updated_at' => Carbon::now('Europe/Amsterdam'),
                'error'      => false,
            ]);

            return redirect(route('admin.import::success'))->with([
                'type' => 'product',
            ]);
        } else {
            return redirect()
                ->back()
                ->withErrors('Geen bestand geselecteerd');
        }
    }

    /**
     * This function will handle the discount import.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function discount(Request $request, Content $content)
    {
        if ($request->hasFile('discountFile')) {
            $file = $request->file('discountFile');

            $file->move(storage_path().'/import', 'discounts.csv');

            $runTime = new \DateTime('Europe/Amsterdam');
            $runTime->setTimestamp(strtotime('+'.app('helper')->timeToNextCronJob().' minutes'));

            Content::where('name', 'admin.discount_import')->update([
                'content'    => 'Er is een import ingepland voor '.$runTime->format('H:i'),
                'updated_at' => Carbon::now('Europe/Amsterdam'),
                'error'      => false,
            ]);

            return redirect(route('admin.import::success'))->with([
                'type' => 'korting',
            ]);
        } else {
            return redirect()
                ->back()
                ->withErrors('Geen bestand geselecteerd');
        }
    }

    /**
     * This function will handle the image import.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function image(Request $request, Content $content)
    {
        if ($request->hasFile('imageFile') && $request->file('imageFile')->isValid()) {
            $file = $request->file('imageFile');
            $fileName = $file->getClientOriginalName();
            $fileMime = $file->getMimeType();
            $startTime = microtime(true);
            $validator = Validator::make(
                ['fileType' => $file],
                ['fileType' => 'required|mimes:zip,jpg,png,gif,jpeg']
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors('Geen geldig bestand geuploaded. Het bestand mag een afbeeling of Zip bestand zijn');
            } else {
                if ($fileMime === 'application/zip') {
                    // Unzip the files to the product image folder
                    \Zipper::make($file->getRealPath())->extractTo(public_path().'/img/products');

                    // This is used to count the number of files in the zip
                    $zip = new \ZipArchive();
                    $zip->open($file->getRealPath());
                    $count = $zip->numFiles;
                } else {
                    // If it's an image file, move it directly to the product image folder
                    $file->move(public_path().'/img/products', $fileName);

                    $count = 1;
                }

                $endTime = round(microtime(true) - $startTime, 4);

                return redirect(route('admin.import::success'))->with([
                    'count' => $count,
                    'time'  => $endTime,
                    'type'  => 'afbeelding',
                ]);
            }
        } else {
            return redirect()
                ->back()
                ->withErrors('Geen bestand geselecteerd of de afbeelding is ongeldig');
        }
    }

    /**
     * This function will handle the downloads import.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function download(Request $request, Content $content)
    {
        if ($request->hasFile('imageFile') && $request->file('imageFile')->isValid()) {
            $file = $request->file('imageFile');
            $fileName = $file->getClientOriginalName();
            $fileMime = $file->getMimeType();
            $startTime = microtime(true);

            $validator = Validator::make(
                ['fileType' => $file],
                ['fileType' => 'required|mimes:zip,pdf']
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors('Geen geldig bestand geuploaded. Het bestand mag een Zip of PDF bestand zijn');
            } else {
                $file->move(public_path().'/dl', $fileName);

                $count = 1;

                $endTime = round(microtime(true) - $startTime, 4);

                return redirect(route('admin.import::success'))->with([
                    'count' => $count,
                    'time'  => $endTime,
                    'type'  => 'download',
                ]);
            }
        } else {
            return redirect()
                ->back()
                ->withErrors('Geen bestand geselecteerd of het bestand is ongeldig');
        }
    }

    /**
     * The import was successful :D.
     *
     * @param  Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function success(Request $request)
    {
        // The type must be set
        if ($request->session()->has('type')) {
            return view('admin::import.success');
        } else {
            // Or you will be redirected
            return redirect()
                ->route('admin::import');
        }
    }
}

<?php

namespace WTG\Admin\Controllers;

use WTG\Models\Description;
use WTG\Block\Models\Block;
use Illuminate\Http\Request;
use WTG\Catalog\Models\Product;

/**
 * Class ContentController.
 *
 * @package     WTG\Admin
 * @subpackage  Controllers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class ContentController extends Controller
{
    /**
     * Content manager.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $blocks = Block::editable()->get()->sortBy(function ($block) {
            return $block->getName();
        });

        return view('admin.content.index', compact('blocks'));
    }

    /**
     * Get the content that belongs to the page/field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function content(Request $request)
    {
        if ($request->has('block')) {
            $data = Block::getByTag($request->input('block'));

            if ($data) {
                return response()->json([
                    'message' => 'Content for block '.$request->input('block'),
                    'payload' => $data,
                ]);
            } else {
                return response()->json([
                    'message' => 'No content found for block: '.$request->input('block'),
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Missing request parameter: `block`',
            ], 400);
        }
    }

    /**
     * Get the description of a product.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function description(Request $request)
    {
        if ($request->has('product')) {
            $product = Product::findByNumber($request->input('product'));

            if (! is_null($product)) {
                if ($product->description) {
                    return response()->json([
                        'message' => 'Description for product '.$request->input('product'),
                        'payload' => $product->description,
                    ]);
                } else {
                    return response()->json([
                        'message' => 'No description found for product: '.$request->input('product'),
                    ], 404);
                }
            } else {
                return response()->json([
                    'message' => 'No product found with id: '.$request->input('product'),
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Missing request parameter: `product`',
            ], 400);
        }
    }

    /**
     * Save the content to the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function savePage(Request $request)
    {
        if ($request->has('block') && $request->has('content')) {
            $content = $request->input('content');
            $block = $request->input('block');

            $block = Block::getByTag($block);
            $block->setContent($content);
            $block->save();

            return redirect()
                ->back()
                ->with('status', 'De content is aangepast');
        } else {
            return redirect()
                ->back()
                ->withErrors('Content of Field veld leeg');
        }
    }

    /**
     * Save the product description.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveDescription(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'product' => 'required',
        ]);

        if ($validator->passes()) {
            $content = $request->input('content');
            $product = $request->input('product');

            if (null === Product::findByNumber($product)) {
                return redirect()
                    ->back()
                    ->withErrors('Geen product gevonden met nummer '.$product);
            }

            $description = Description::firstOrCreate([
                'product_id' => $product,
            ]);

            $description->value = $content;
            $description->save();

            return redirect()
                ->back()
                ->with('status', 'De product omschrijving is aangepast');
        } else {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }
    }
}

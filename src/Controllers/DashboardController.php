<?php

namespace WTG\Admin\Controllers;

use Illuminate\Http\Request;
use WTG\Admin\Services\Stats;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use WTG\Checkout\Interfaces\OrderInterface as Order;
use WTG\Content\Interfaces\ContentInterface as Content;

/**
 * Dashboard controller.
 *
 * @package     WTG\Admin
 * @subpackage  Controllers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class DashboardController extends Controller
{
    /**
     * The dashboard view.
     *
     * @param  Request  $request
     * @param  Content  $content
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function view(Request $request, Content $content)
    {
        $years = $request->input('years', null);

        if (is_null($years) || is_array($years)) {
            $product_import = $content->tag('admin.product_import')->first();
            $discount_import = $content->tag('admin.discount_import')->first();
            $orderData = $this->getOrderData($years);
            $orders = $orderData->get('orders');
            $averagePerMonth = $orderData->get('average');

            return view('admin::dashboard.index', compact('product_import', 'discount_import', 'orders', 'averagePerMonth'));
        } else {
            return redirect()
                ->route('admin::dashboard');
        }
    }

    /**
     * Get the server stats.
     *
     * @param  Stats  $stats
     * @return \Illuminate\Http\JsonResponse
     */
    public function stats(Stats $stats): JsonResponse
    {
        $cpuData = $stats->cpu();
        $ramData = $stats->ram();
        $diskData = $stats->disk();

        return response()->json([
            'cpu' => $cpuData,
            'ram' => $ramData,
            'disk' => $diskData,
        ]);
    }

    /**
     * Get the order data
     *
     * @param  array|null  $years
     * @return \Illuminate\Support\Collection
     */
    protected function getOrderData(array $years = null): Collection
    {
        $averagePerMonth = [0,0,0,0,0,0,0,0,0,0,0,0];

        $orders = app()->make(Order::class)
            ->get()
            ->groupBy(function ($item, $key) {
                return $item->created_at->format('Y');
            })
            ->map(function ($item, $key) use (&$averagePerMonth, $years) {
                if ($years !== null) {
                    if (!in_array($key, $years)) {
                        return;
                    }
                }

                return $item->groupBy(function ($item, $key) {
                    return $item->created_at->format('n');
                })->map(function ($item, $key) use (&$averagePerMonth) {
                    $averagePerMonth[$key-1] += $item->count();

                    return $item->count();
                });
            });

        $averagePerMonth = collect($averagePerMonth)->map(function ($item, $key) use ($orders) {
            $count = $orders->filter(function ($item) {
                return $item !== null;
            })->keys()->count();

            if ($count === 0) {
                return 0;
            }

            return $item / $count;
        });

        return collect([
            'average' => $averagePerMonth,
            'orders' => $orders
        ]);
    }
}

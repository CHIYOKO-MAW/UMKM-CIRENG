<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $paidOrders = Order::paidForAdmin();
        $completedAtExpression = 'COALESCE(completed_at, updated_at)';
        $rangeOptions = [7, 14, 30, 90];
        $selectedRange = (int) $request->integer('range', 14);
        if (!in_array($selectedRange, $rangeOptions, true)) {
            $selectedRange = 14;
        }

        $totalOrders = (clone $paidOrders)->count();
        $stageWaitingVerification = (clone $paidOrders)->where('status', 'payment_uploaded')->count();
        $stageProcessing = (clone $paidOrders)->whereIn('status', ['confirmed', 'processing'])->count();
        $stageReadyToShip = (clone $paidOrders)->where('status', 'ready')->count();
        $completedOrders = (clone $paidOrders)->where('status', 'completed')->count();
        $completedToday = (clone $paidOrders)
            ->where('status', 'completed')
            ->whereDate(DB::raw($completedAtExpression), now()->toDateString())
            ->count();
        $totalRevenue = (clone $paidOrders)->where('status', 'completed')->sum('total_price');
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = (clone $paidOrders)
            ->with('user', 'items')
            ->latest()
            ->take(10)
            ->get();

        $startDate = now()->subDays($selectedRange - 1)->startOfDay();

        $trendRows = Order::paidForAdmin()
            ->where('status', 'completed')
            ->where(DB::raw($completedAtExpression), '>=', $startDate)
            ->selectRaw('DATE(' . $completedAtExpression . ') as trend_date, COUNT(*) as order_count, SUM(total_price) as revenue')
            ->groupBy('trend_date')
            ->orderBy('trend_date')
            ->get()
            ->keyBy('trend_date');

        $salesTrend = collect();
        for ($i = 0; $i < $selectedRange; $i++) {
            $date = $startDate->copy()->addDays($i);
            $key = $date->toDateString();
            $row = $trendRows->get($key);

            $salesTrend->push([
                'date' => $key,
                'day_label' => Carbon::parse($key)->translatedFormat('d M'),
                'orders' => (int) ($row->order_count ?? 0),
                'revenue' => (float) ($row->revenue ?? 0),
            ]);
        }

        $rangeRevenue = (float) $salesTrend->sum('revenue');
        $rangeOrders = (int) $salesTrend->sum('orders');
        $topRevenueDay = $salesTrend->sortByDesc('revenue')->first();
        $topOrdersDay = $salesTrend->sortByDesc('orders')->first();
        $trendSnapshot = $salesTrend->reverse()->take(min(10, $selectedRange))->values();

        return view('admin.dashboard', compact(
            'totalOrders',
            'stageWaitingVerification',
            'stageProcessing',
            'stageReadyToShip',
            'completedOrders',
            'completedToday',
            'totalRevenue',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'salesTrend',
            'selectedRange',
            'rangeOptions',
            'rangeRevenue',
            'rangeOrders',
            'topRevenueDay',
            'topOrdersDay',
            'trendSnapshot'
        ));
    }
}

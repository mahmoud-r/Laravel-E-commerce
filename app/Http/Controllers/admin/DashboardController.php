<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        //Total ALL Time

        //totalOrders
        $totalOrders =Order::whereHas('status',function ($q){
            $q->where('status','!=','cancelled');
        })->count();

        //Count of product
        $productsCount = Product::count();

        //Count of product
        $usersCount = User::Count();

        //total Revenue
        $totalRevenue =Order::whereHas('status',function ($q){
            $q->where('status','!=','cancelled')
                ->where('status', 'completed');
        })->sum('grand_total');


        //monthly Revenue
        $monthlyRevenue = Order::whereHas('status', function($q) {
            $q->where('status', '!=', 'cancelled');
        })
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(grand_total) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $data = [
            'labels' => $labels ?? [],
            'data' => $data ?? [],
        ];
        foreach ($monthlyRevenue as $revenue) {
            $monthName = Carbon::createFromDate($revenue->year, $revenue->month)->format('F Y');
            $data['labels'][] = $monthName;
            $data['data'][] = $revenue->total;
        }


        // current Month
        $currentMonth = now()->month;
        $pendingOrders = Order::whereHas('status', function($q) use ($currentMonth) {
            $q->whereIn('status', ['pending','processing','shipping'])->whereMonth('created_at', $currentMonth);
        })->sum('grand_total');

        $completedOrders = Order::whereHas('status', function($q) use ($currentMonth) {
            $q->where('status', 'completed')->whereMonth('created_at', $currentMonth);
        })->sum('grand_total');


        return view('admin.dashboard',compact(
            'totalOrders',
            'productsCount',
            'usersCount',
            'totalRevenue',
            'data',
            'pendingOrders',
            'completedOrders',
        ));
    }
}

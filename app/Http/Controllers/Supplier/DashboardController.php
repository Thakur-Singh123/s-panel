<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\AddSupplier;

class DashboardController extends Controller
{
    //Function for show dashboard
    public function dashboard() {
        //Get  logged In supplier
        $supplierId = session('supplier_id');
        $loginType  = session('login_type');

        if (empty($supplierId)) {
            return redirect()
                ->route('login')
                ->with('unsuccess', 'Please login first.');
        }
        //Get supplier details
        $supplier = AddSupplier::query()
            ->select([
                'add_supplier_id',
                'name',
                'company_name',
                'email',
                'contact_person',
                'telephone',
                'isactive',
            ])
            ->where(
                'add_supplier_id',
                $supplierId
            )
            ->first();
        if (!$supplier) {
            session()->forget([
                'login_type',
                'supplier_id',
                'sub_supplier_id',
            ]);
            return redirect()->route('login')->with('unsuccess','Supplier account not found.');
        }
        //Supplier Orders
        $ordersQuery = Order::query()->where('assign_supplier', $supplierId);
        //Total Bookings
        $totalBookings = (clone $ordersQuery)->count();
        //Active Tours
        $activeTours = (clone $ordersQuery)
            ->whereRaw(
                'LOWER(TRIM(type)) = ?',
                ['tour']
            )
            ->count();
        //Active Transfers
        $activeTransfers = (clone $ordersQuery)
            ->whereRaw(
                'LOWER(TRIM(type)) = ?',
                ['transfer']
            )
            ->count();
        //Packages
        $packageCount = (clone $ordersQuery)
            ->whereRaw(
                'LOWER(TRIM(type)) = ?',
                ['package']
            )
            ->count();
        //Hotels
        $hotelCount = (clone $ordersQuery)
            ->whereRaw(
                'LOWER(TRIM(type)) = ?',
                ['hotel']
            )
            ->count();
        //Today's Bookings
        $todayBookings = (clone $ordersQuery)
            ->whereDate(
                'date',
                Carbon::today()
            )
            ->count();
        //Sub Suppliers
        $subSuppliers = DB::table('add_sub_supplier')
            ->where(
                'supplier_id',
                (string) $supplierId
            )
            ->count();
        $activeSubSuppliers = DB::table('add_sub_supplier')
            ->where(
                'supplier_id',
                (string) $supplierId
            )
            ->where(
                'status',
                '1'
            )
            ->count();
        //Recent Bookings
        $recentBookings = (clone $ordersQuery)
            ->select([
                'id',
                'item_name',
                'type',
                'first_name',
                'last_name',
                'start_date',
                'date',
                'status',
            ])
            ->orderByDesc('id')
            ->limit(5)
            ->get();
        //Pending / Attention

        $pendingBookings = (clone $ordersQuery)
            ->where(function ($query) {

                $query->whereRaw(
                    'UPPER(TRIM(status)) = ?',
                    ['PENDING']
                )
                ->orWhereRaw(
                    'UPPER(TRIM(status)) = ?',
                    ['CONFIRMATION PENDING']
                )
                ->orWhereRaw(
                    'UPPER(TRIM(status)) = ?',
                    ['CANCELLATION PENDING']
                );
            })
            ->count();
        //Recent Activity
        $recentActivity = (clone $ordersQuery)
            ->select([
                'id',
                'item_name',
                'type',
                'status',
                'date',
                'timestamp',
            ])
            ->orderByDesc('id')
            ->limit(3)
            ->get();
        //Greeting
        $hour = now()->hour;
        if ($hour < 12) {
            $greeting = 'Good morning';
        } elseif ($hour < 18) {
            $greeting = 'Good afternoon';
        } else {
            $greeting = 'Good evening';
        }
        //Dashboard
        return view('supplier.dashboard.index', compact('supplier','supplierId','loginType','totalBookings','activeTours','activeTransfers','packageCount','hotelCount','subSuppliers','activeSubSuppliers','todayBookings','recentBookings','pendingBookings','recentActivity','greeting'));
    }
}
<?php

namespace App\Http\Controllers\Admin\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Models\Users\Admin;
use App\Models\Users\User;
use App\Models\ActivityLogs\ActivityLog;

class DashboardAnalyticsController extends Controller
{
    protected $startDate;
    protected $endDate;

    public function fetch(Request $request) {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $this->startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d') . " 00:00:00";
            $this->endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d') . " 23:59:59";
        }

        if ($request->filled('admin')) {
            $users = new Admin;
            $subject = 'App\Models\Users\Admin';
        } else {
            $users = new User;
            $subject = 'App\Models\Users\User';
        }

        $activities = $this->getUserActivity($users);
        $usage = $this->getSystemUsageAnalytics($users, $subject);

    	return response()->json(array_merge($usage, $activities));
    }

    protected function getUserActivity($items) {
        if ($this->startDate && $this->endDate) {
            $items = $items->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }
        
        $active = $items->whereDate('created_at', '!=', now())->count();
        $inactive = $items->onlyTrashed()->count();

        return [
            'active' => $active,
            'inactive' => $inactive,
        ];
    }

    protected function getSystemUsageAnalytics($items, $subject) {
        if ($this->startDate && $this->endDate) {
            $items = $items->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $item_count = $items->count();

        $filters = [
            'description' => 'Account has been logged in.', 
        ];

        $logs = ActivityLog::where($filters);

        if ($this->startDate && $this->endDate) {
            $logs = $logs->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $item_login = $logs->where('causer_type', $subject)->pluck('causer_id')->unique()->count();
        
        if ($item_count > 0) {
            $item_usage = number_format(($item_login / ($item_count)) * 100, 2, '.', '');
        } else {
            $item_usage = 0;
        }

        $item_usage_chart = [
            [
                'label' => 'System Usage',
                'data' => $item_usage,
                'backgroundColor' => '#007bff',
            ],
            [
                'label' => 'Unallocated Resources',
                'data' => 100 - $item_usage,
                'backgroundColor' => '#ccc',
            ],
        ];

        return [
            'count' => $item_count,
            'login' => $item_login,
            'usage' => $item_usage . ' %',
            'usage_chart' => $item_usage_chart,
        ];
    }
}

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

        $revenue = [
            [
                "backgroundColor" => "#007bff",
                "data" => 80.00,
                "label" => "January"
            ],
            [
                "backgroundColor" => "red",
                "data" => 99.00,
                "label" => "February"
            ],
            [
                "backgroundColor" => "green",
                "data" => 100.00,
                "label" => "March"
            ],
            [
                "backgroundColor" => "green",
                "data" => 100.00,
                "label" => "April"
            ],
            [
                "backgroundColor" => "green",
                "data" => 200.00,
                "label" => "May"
            ]
        ];

        $visitor_types = [
            [
                "backgroundColor" => "#007bff",
                "data" => 80.00,
                "label" => "Non-Filipino"
            ],
            [
                "backgroundColor" => "red",
                "data" => 99.00,
                "label" => "Filipino"
            ],
            [
                "backgroundColor" => "green",
                "data" => 100.00,
                "label" => "Resident"
            ],
        ];

        $ages = [
            [
                "backgroundColor" => "#007bff",
                "data" => 80.00,
                "label" => "18-25"
            ],
            [
                "backgroundColor" => "red",
                "data" => 99.00,
                "label" => "26-35"
            ],
            [
                "backgroundColor" => "green",
                "data" => 20,
                "label" => "35-40"
            ],
        ];

        $nationalities = [
            [
                "backgroundColor" => "#007bff",
                "data" => 80.00,
                "label" => "Filipino"
            ],
            [
                "backgroundColor" => "red",
                "data" => 99.00,
                "label" => "Japanese"
            ],
            [
                "backgroundColor" => "green",
                "data" => 20,
                "label" => "Korean"
            ],
            [
                "backgroundColor" => "green",
                "data" => 20,
                "label" => "Korean"
            ],
        ];

        $gender = [
            [
                "backgroundColor" => "#007bff",
                "data" => 80.00,
                "label" => "Male"
            ],
            [
                "backgroundColor" => "red",
                "data" => 99.00,
                "label" => "Female"
            ],
        ];

        $source = [
            [
                "backgroundColor" => "#007bff",
                "data" => 80.00,
                "label" => "Walk In"
            ],
            [
                "backgroundColor" => "red",
                "data" => 99.00,
                "label" => "Online"
            ],
            [
                "backgroundColor" => "yellow",
                "data" => 20,
                "label" => "Agency"
            ],
        ];

        $special_fees = [
            [
                "backgroundColor" => "#007bff",
                "data" => 80.00,
                "label" => "Students"
            ],
            [
                "backgroundColor" => "red",
                "data" => 30,
                "label" => "PWD"
            ],
            [
                "backgroundColor" => "yellow",
                "data" => 20,
                "label" => "Senior"
            ],
        ];

        return [
            'count' => $item_count,
            'login' => $item_login,
            'usage' => $item_usage . ' %',
            'usage_chart' => $item_usage_chart,
            'revenue' => $revenue,
            'visitor_types' => $visitor_types,
            'ages' => $ages,
            'nationalities' => $nationalities,
            'gender' => $gender,
            'source' => $source,
            'special_fees' => $special_fees,
        ];
    }
}

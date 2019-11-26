<?php

namespace App\Http\Controllers\Admin\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Models\Users\Admin;
use App\Models\Users\User;
use App\Models\ActivityLogs\ActivityLog;

use App\Models\Guests\Guest;

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

    	return response()->json($usage);
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
        $ranges = [ // the start of each age-range.
            '18-24' => 18,
            '25-35' => 25,
            '36-45' => 36,
            '46+' => 46
        ];

        $ages = Guest::get()->map(function($guest) use ($ranges) {
            $age = Carbon::parse($guest->birthdate)->age;

            foreach ($ranges as $key => $breakpoint) {
                if($breakpoint >= $age) {
                    $guest->range = $key;
                    $guest->age = $age;
                    break;
                }
            }

            return $guest;
        })->mapToGroups(function($guest, $key) {
            return [$guest->age => $guest];
        })->map(function($group) {
            return count($group);
        });
        dd($ages);
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

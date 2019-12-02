<?php

namespace App\Http\Controllers\Admin\Analytics;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Models\Users\Admin;
use App\Models\Users\User;
use App\Models\Books\Book;
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
        
        $today = Carbon::now();
        // get all booking based on current destination assigned for logged-in user
        $bookings = Book::whereDate('scheduled_at', $today);
        
        // total of guest today
        $total['guest'] = $bookings->sum('total_guest');

        // total of groups today
        $total['groups'] = $bookings->get()->count();
        
        // get total checked in for walk in guest
        $checked_in_walkin['visitors'] = $bookings->where('is_walkin', true)->whereDate('checked_in_at', $today)->get()->count(); 
        $checked_in_walkin['groups'] = $bookings->where('is_walkin', true)->whereDate('checked_in_at', $today)->get()->count(); 

        // get total checked in for online in guest
        $total_checked_in['online_visitor'] = $bookings->where('is_walkin', false)->whereDate('checked_in_at', $today)->get()->count(); 
        $total_checked_in['online_group'] = $bookings->where('is_walkin', false)->where('is_walkin', false)->whereDate('checked_in_at', $today)->get()->count(); 
        $total_checked_in['walk_in'] = $bookings->where('is_walkin', true)->whereDate('checked_in_at', $today)->get()->count(); 
        $total_checked_in['walk_in_group'] = $bookings->where('is_walkin', true)->where('is_walkin', false)->whereDate('checked_in_at', $today)->get()->count(); 

        $nationalities = [];
        $guests = Guest::all();

        foreach ($guests as $key => $guest) {
            if(empty($nationalities)) {
                array_push($nationalities, [
                    "backgroundColor" => "#007bff",
                    "data" => 1,
                    "label" => $guest->nationality,
                ]);    
            } else {
                $needle = $guest->nationality;
                $index = array_search($needle, array_column($nationalities, 'label'));

                foreach ($nationalities as $key => $nationality) {
                    if($nationality['label'] === $needle) {
                        $nationalities[$key]['data'] += 1;
                    } 

                    if($nationalities[$key]['label']) {
                        array_push($nationalities, [
                            "backgroundColor" => "#007bff",
                            "data" => 1,
                            "label" => $guest->nationality,
                        ]);
                    }
                }
            }
        }

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

        // $nationalities = [
        //     [
        //         "backgroundColor" => "#007bff",
        //         "data" => 80.00,
        //         "label" => "Filipino"
        //     ],
        //     [
        //         "backgroundColor" => "red",
        //         "data" => 99.00,
        //         "label" => "Japanese"
        //     ],
        //     [
        //         "backgroundColor" => "green",
        //         "data" => 20,
        //         "label" => "Korean"
        //     ],
        //     [
        //         "backgroundColor" => "green",
        //         "data" => 20,
        //         "label" => "Korean"
        //     ],
        // ];

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
            'total' => $total,
            'checked_in_walkin' => $checked_in_walkin,
            'total_checked_in' => $total_checked_in
        ];
    }
}

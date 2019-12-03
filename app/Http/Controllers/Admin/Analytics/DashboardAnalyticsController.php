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
use DB;

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

        // get all the nationality of all guests

        $collection = Guest::with('visitorType', 'specialFee')->get();
        $grouped = $collection->groupBy(function($item, $key) {
            return $item['nationality'];
        });
        $nationalities = $this->renderGraphDigits($grouped);

        // get all the type of visitor of the guests

        $grouped = $collection->groupBy(function($item, $key) {
            return $item->visitorType ? $item->visitorType->name  : [];
        });

        $visitor_types = $this->renderGraphDigits($grouped);

        // get all the gender of the guests
        $grouped = $collection->groupBy(function($item, $key) {
            return $item['gender'];
        });

        $gender = $this->renderGraphDigits($grouped);

        // get all the $source of the book/reservation
        $book = Book::all();
        $grouped = $book->groupBy(function($item, $key) {
            return $item['is_walkin'] == true ? 'Walk-In' : 'Online';
        });

        $source = $this->renderGraphDigits($grouped);
        
        // get all the special fee of the guests
        $grouped = $collection->groupBy(function($item, $key) {
            return $item->specialFee ? $item->specialFee->name : [];
        });

        $special_fees = $this->renderGraphDigits($grouped);


        // $guests = Guest::agedBetween(22)->get();
        // $now = Carbon::now();
        // $start = $now->subYears(18);
        // $end = $now->subYears(30)->addYear()->subDay(); // plus 1 year minus a day

        // $guests = Guest::whereBetween('birthdate', [$start, $end])->get();
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

    public function renderGraphDigits($grouped) 
    {
        $data = [];
        $groupCount = $grouped->map(function ($item, $key) {
            return collect($item)->count();
        });

        foreach ($groupCount as $key => $value) {
            array_push($data, [
                    "backgroundColor" => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                    "data" => $value,
                    "label" => $key,
                ]);
        }

        return $data;
    }
}

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
use App\Models\Invoices\Invoice;
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

        $usage = $this->getSystemUsageAnalytics($users, $subject, $request);

    	return response()->json($usage);
    }

    protected function getSystemUsageAnalytics($items, $subject, $request) {
        $today = Carbon::now();
        $capacity['groups'] = 0;
        $capacity['visitors'] = 0;

        if($request->date) {
            $today = $request->date;
        }
        // get all booking based on current destination assigned for logged-in user
        $bookings = Book::whereDate('scheduled_at', $today)->whereNotNull('started_at');
        if($request->date) {
            $bookings = Book::whereDate('scheduled_at', $request->date)->whereNotNull('started_at');
        }

        if($request->destination && $request->destination != null) {
            $bookings = Book::where('destination_id', $request->destination);
        } 

        if($request->experience) {
            $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience);
        }
        // total of guest

        if($request->date) {
            $total['guest'] = $bookings->whereDate('scheduled_at', $request->date)->whereNotNull('started_at')->sum('total_guest');
        } else {
            $total['guest'] = $bookings->whereDate('scheduled_at', $today)->whereNotNull('started_at')->sum('total_guest');
        }
        // total of groups
        if($request->date) {
            $total['groups'] = $bookings->whereDate('scheduled_at', $request->date)->whereNotNull('started_at')->get()->count();
        } else {
            $total['groups'] = $bookings->whereDate('scheduled_at', $today)->whereNotNull('started_at')->get()->count();
        }
        
        $bookings = Book::whereDate('scheduled_at', $today);
        if($request->date) {
            $bookings = Book::whereDate('scheduled_at', $request->date);
        }

        if($request->destination && $request->destination != null) {
            $bookings = Book::where('destination_id', $request->destination);
        } 

        if($request->experience) {
            $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience);
        }

        if($request->destination) {
            $bookings = Book::where('destination_id', $request->destination);
        } 

        if($request->experience) {
            $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience);
        }
        // get total checked in for walk in guest
        if($request->date) {
            $checked_in_walkin['visitors'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->sum('total_guest'); 
        } else {
            $checked_in_walkin['visitors'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->sum('total_guest'); 
        }
        if($request->date) {
            $checked_in_walkin['groups'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->count(); 
        } else {
            $checked_in_walkin['groups'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->count(); 
        }
        
        // get total checked in for online in guest
        $bookings = Book::whereDate('scheduled_at', $today);
        if($request->date) {
            $bookings = Book::whereDate('scheduled_at', $request->date);
        }
        $total_checked_in['online_visitor'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->sum('total_guest'); 
        $total_checked_in['online_group'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();

        if($request->destination) {
            $bookings = Book::where('destination_id', $request->destination);
            $total_checked_in['online_visitor'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->sum('total_guest'); 
            $total_checked_in['online_group'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
            if($request->date) {
                $total_checked_in['online_visitor'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', false)->whereNotNull('started_at')->get()->sum('total_guest');
                $total_checked_in['online_group'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
            } 
        } 

        if($request->experience) {
            $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience);
            $total_checked_in['online_visitor'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->sum('total_guest'); 
            $total_checked_in['online_group'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
            if($request->date) {
                $total_checked_in['online_visitor'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', false)->whereNotNull('started_at')->get()->sum('total_guest');
                $total_checked_in['online_group'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
            } 
        }

        if($request->date) {
            $total_checked_in['online_visitor'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', false)->whereNotNull('started_at')->get()->sum('total_guest');
        } else {
            $total_checked_in['online_visitor'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', false)->whereNotNull('started_at')->get()->sum('total_guest'); 
        }

        // $bookings = Book::whereDate('scheduled_at', $today);
        // if($request->date) {
        //     $bookings = Book::whereDate('scheduled_at', $request->date);
        // }

        // if($request->destination && $request->destination != null) {
        //     $bookings = Book::where('destination_id', $request->destination);
        // } 

        // if($request->experience) {
        //     $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience);
        // }

        // if($request->date) {
        //     $total_checked_in['online_group'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
        // } else {
        //     $total_checked_in['online_group'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count(); 
        // }

        // $bookings = Book::whereDate('scheduled_at', $today);
        // if($request->date) {
        //     $bookings = Book::whereDate('scheduled_at', $request->date);
        // }

        // if($request->destination && $request->destination != null) {
        //     $bookings = Book::where('destination_id', $request->destination);
        // } 

        // if($request->experience) {
        //     $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience);
        // }

        $bookings = Book::whereDate('scheduled_at', $today)->whereNotNull('started_at');
        $total_checked_in['walk_in'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->sum('total_guest'); 
        $total_checked_in['walk_in_group'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->count();  

        if($request->destination) {
            $bookings = Book::where('destination_id', $request->destination);
            $total_checked_in['walk_in'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->sum('total_guest'); 
            $total_checked_in['walk_in_group'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->count();  
            if($request->date) {
                $total_checked_in['walk_in_group'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', true)->whereNotNull('started_at')->get()->count();  
                $total_checked_in['walk_in'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', true)->whereNotNull('started_at')->get()->sum('total_guest'); 
            } 
        } 

        if($request->experience) {
            $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience);
            $total_checked_in['walk_in'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->sum('total_guest'); 
            $total_checked_in['walk_in_group'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->count();  
            if($request->date) {
                $total_checked_in['walk_in_group'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', true)->whereNotNull('started_at')->get()->count();  
                $total_checked_in['walk_in'] = $bookings->whereDate('scheduled_at', $request->date)->where('is_walkin', true)->whereNotNull('started_at')->get()->sum('total_guest'); 
            } 
        }
        if($request->date) {
            $total_checked_in['walk_in'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->sum('total_guest'); 
            $total_checked_in['walk_in_group'] = $bookings->where('is_walkin', true)->whereNotNull('started_at')->get()->count();  
        } 

        $bookings = Book::whereDate('scheduled_at', $today)->get()->pluck('id')->toArray();
        $collection = Guest::with('visitorType', 'specialFee')->whereIn('book_id', $bookings)->where('main', false)->get();

        if($request->destination) {
            $bookings = Book::whereDate('scheduled_at', $today)->where('destination_id', $request->destination)->get()->pluck('id')->toArray();
            if($request->date) {
                $bookings = Book::where('destination_id', $request->destination)->whereDate('scheduled_at', $request->date)->get()->pluck('id')->toArray();
            }
            $collection = Guest::with('visitorType', 'specialFee')->where('main', false)->whereIn('book_id', $bookings)->get();
        } 

        if($request->experience) {
            $bookings = Book::whereDate('scheduled_at', $today)->where('destination_id', $request->destination)->where('allocation_id', $request->experience)->get()->pluck('id')->toArray();
            if($request->date) {
                $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience)->whereDate('scheduled_at', $request->date)->get()->pluck('id')->toArray();
            }
            $collection = Guest::with('visitorType', 'specialFee')->where('main', false)->whereIn('book_id', $bookings)->get();
        }
        // get all the nationality of all guests

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
        $book = Book::whereDate('scheduled_at', $today)->get();

        if($request->destination) {
            $book = Book::whereDate('scheduled_at', $today)->where('destination_id', $request->destination)->get();
            if($request->date) {
                $book = Book::where('destination_id', $request->destination)->whereDate('scheduled_at', $request->date)->get();
            }
        } 

        if($request->experience) {
            $book = Book::whereDate('scheduled_at', $today)->where('destination_id', $request->destination)->where('allocation_id', $request->experience)->get();
            if($request->date) {
                $book = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience)->whereDate('scheduled_at', $request->date)->get();
            }
        }

        

        $grouped = $book->groupBy(function($item, $key) {
            return $item['is_walkin'] == true ? 'Walk-In' : 'Online';
        });

        $source = $this->renderGraphDigits($grouped);
        
        // get all the special fee of the guests
        $grouped = $collection->groupBy(function($item, $key) {
            return $item->specialFee ? $item->specialFee->name : [];
        });

        $special_fees = $this->renderGraphDigits($grouped);

        

        $revenue = [
            [
                "backgroundColor" => "#007bff",
                "data" => $this->getGrandTotal($request, 1),
                "label" => "January"
            ],
            [
                "backgroundColor" => "red",
                "data" => $this->getGrandTotal($request, 2),
                "label" => "February"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 3),
                "label" => "March"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 4),
                "label" => "April"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 5),
                "label" => "May"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 6),
                "label" => "June"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 7),
                "label" => "July"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 8),
                "label" => "August"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 9),
                "label" => "September"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 10),
                "label" => "October"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 11),
                "label" => "November"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGrandTotal($request, 12),
                "label" => "December"
            ]
        ];

        $ages = [
            [
                "backgroundColor" => "#673ab7",
                "data" => $this->getGuestAge($request, [10, 17]),
                "label" => "10-18"
            ],
            [
                "backgroundColor" => "#007bff",
                "data" => $this->getGuestAge($request, [18, 25]),
                "label" => "18-25"
            ],
            [
                "backgroundColor" => "red",
                "data" => $this->getGuestAge($request, [26, 35]),
                "label" => "26-35"
            ],
            [
                "backgroundColor" => "green",
                "data" => $this->getGuestAge($request, [35, 40]),
                "label" => "35-40"
            ],
            [
                "backgroundColor" => "yellow",
                "data" => $this->getGuestAge($request, [41, 300]),
                "label" => "41 +"
            ],
        ];

        $bookings = Book::whereDate('scheduled_at', $today)->whereNotNull('started_at');
        $capacity['groups'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
        $capacity['visitors'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->sum('total_guest');

        if($request->date) {
            $bookings = Book::whereDate('scheduled_at', $request->date)->whereNotNull('started_at');
            $capacity['groups'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
            $capacity['visitors'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->sum('total_guest');
        }

        if($request->destination && $request->destination != null) {
            $bookings = Book::where('destination_id', $request->destination);
            $capacity['groups'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
            $capacity['visitors'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->sum('total_guest');
            if($request->date) {
                $bookings = $bookings->whereDate('scheduled_at', $request->date)->whereNotNull('started_at');
                $capacity['groups'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
                $capacity['visitors'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->sum('total_guest');
            }
        } 

        if($request->experience) {
            $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience);
            $capacity['groups'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
            $capacity['visitors'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->sum('total_guest');
            if($request->date) {
                $bookings = $bookings->whereDate('scheduled_at', $request->date)->whereNotNull('started_at');
                $capacity['groups'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->get()->count();
                $capacity['visitors'] = $bookings->where('is_walkin', false)->whereNotNull('started_at')->sum('total_guest');
            }
        }

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
            'total_checked_in' => $total_checked_in,
            'capacity' => $capacity
        ];
    }

    public function getGrandTotal($request, $month) {
        $invoice = Invoice::whereMonth('created_at', $month)->where('is_paid', true)->withTrashed()->sum('grand_total');


        if($request->destination) {
            $bookings = Book::where('destination_id', $request->destination)->get()->pluck('id')->toArray();
            $invoice = Invoice::whereIn('book_id', $bookings)->whereMonth('created_at', $month)->where('is_paid', true)->withTrashed()->sum('grand_total');
        } 

        if($request->experience) {
            $bookings = Book::where('destination_id', $request->destination)->where('allocation_id', $request->experience)->get()->pluck('id')->toArray();
            $invoice = Invoice::whereIn('book_id', $bookings)->whereMonth('created_at', $month)->where('is_paid', true)->withTrashed()->sum('grand_total');
        }

        return $invoice;

    }

    public function getGuestAge($request, $arr) {
        $today = Carbon::now();
        $bookings = Book::whereDate('scheduled_at', $today)->get()->pluck('id')->toArray();
        $guest = Guest::where('main', false)->whereIn('book_id', $bookings)->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR,birthdate,CURDATE())'), $arr)->count();

        if($request->destination) {
            $bookings = Book::whereDate('scheduled_at', $today)->where('destination_id', $request->destination)->get()->pluck('id')->toArray();
            if($request->date) {
                $bookings = Book::whereDate('scheduled_at', $request->date)->where('destination_id', $request->destination)->get()->pluck('id')->toArray();
            }
            $guest = Guest::where('main', false)->whereIn('book_id', $bookings)->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR,birthdate,CURDATE())'), $arr)->count();
        } 

        if($request->experience) {
            $bookings = Book::whereDate('scheduled_at', $today)->where('destination_id', $request->destination)->where('allocation_id', $request->experience)->get()->pluck('id')->toArray();
            if($request->date) {
                $bookings = Book::whereDate('scheduled_at', $request->date)->where('destination_id', $request->destination)->where('allocation_id', $request->experience)->get()->pluck('id')->toArray();
            }
            $guest = Guest::where('main', false)->whereIn('book_id', $bookings)->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR,birthdate,CURDATE())'), $arr)->count();
        }

        return $guest;
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

<?php

namespace App\Extenders\Controllers\ActivityLogs;

use Illuminate\Http\Request;
use App\Extenders\Controllers\FetchController as Controller;

use App\Models\ActivityLogs\ActivityLog;

use App\Models\Pages\Page;
use App\Models\Pages\MetaTag;

class ActivityLogFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass() 
    {
        $this->class = new ActivityLog;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query) 
    {
        $query = $this->additionalQuery($query);

        $query = $this->filterSubject($query, 'sample', 'App\Models\Samples\SampleItem');
        $query = $this->filterSubject($query, 'roles', 'App\Models\Roles\Role');
        $query = $this->filterSubject($query, 'pageitems', 'App\Models\Pages\PageItem');
        $query = $this->filterSubject($query, 'user', 'App\Models\Users\User');
        $query = $this->filterSubject($query, 'admin', 'App\Models\Users\Admin');
        $query = $this->filterSubject($query, 'articles', 'App\Models\Articles\Article');
        $query = $this->filterSubject($query, 'subject_type', $this->request->input('subject_type'));

        $query = $this->filterSubject($query, 'experiences', 'App\Models\Experiences\Experience');
        $query = $this->filterSubject($query, 'destinations', 'App\Models\Destinations\Destination');
        $query = $this->filterSubject($query, 'inquiries', 'App\Models\Inquiries\Inquiry');
        $query = $this->filterSubject($query, 'annual_incomes', 'App\Models\AnnualIncomes\AnnualIncome');
        $query = $this->filterSubject($query, 'survey-experiences', 'App\Models\Surveys\SurveyExperience');
        $query = $this->filterSubject($query, 'allocations', 'App\Models\Allocations\Allocation');
        $query = $this->filterSubject($query, 'add-ons', 'App\Models\AddOns\AddOn');
        $query = $this->filterSubject($query, 'visitor-types', 'App\Models\Types\VisitorType');
        $query = $this->filterSubject($query, 'fees', 'App\Models\Fees\Fee');
        $query = $this->filterSubject($query, 'feedbacks', 'App\Models\Feedbacks\Feedback');
        $query = $this->filterSubject($query, 'blocked-dates', 'App\Models\BlockedDates\BlockedDate');
        $query = $this->filterSubject($query, 'managements', 'App\Models\Users\Management');
        $query = $this->filterSubject($query, 'training-modules', 'App\Models\TrainingModules\TrainingModule');
        $query = $this->filterSubject($query, 'faqs', 'App\Models\Faqs\Faq');  
        $query = $this->filterSubject($query, 'capacities', 'App\Models\Capacities\Capacity');      
        $query = $this->filterSubject($query, 'agencies', 'App\Models\Agencies\Agency');
        $query = $this->filterSubject($query, 'religions', 'App\Models\Religions\Religion');
        $query = $this->filterSubject($query, 'announcements', 'App\Models\Announcements\Announcement');
        $query = $this->filterSubject($query, 'remarks', 'App\Models\Remarks\Remark');
        $query = $this->filterSubject($query, 'violations', 'App\Models\Violations\Violation');
        $query = $this->filterSubject($query, 'bookings', 'App\Models\Books\Book');
        $query = $this->filterSubject($query, 'surveys', 'App\Models\Surveys\Survey');
        $query = $this->filterSubject($query, 'genders', 'App\Models\Genders\Gender');
        $query = $this->filterSubject($query, 'civil_statuses', 'App\Models\CivilStatuses\CivilStatus');
        $query = $this->filterSubject($query, 'time-slots', 'App\Models\Times\TimeSlot');

        /* Get page and related page item logs */
        if ($this->request->filled('pagecontents')) {
            $subjects = ['App\Models\Pages\PageItem', 'App\Models\Pages\Page', ''];

            $pageIds = $query->where('subject_type', 'App\Models\Pages\Page')->pluck('id')->toArray();
            $pageItems = $query->where('subject_type', 'App\Models\Pages\PageItem');

            if ($this->request->filled('id')) {
                $page = Page::withTrashed()->findOrFail($this->request->input('id'));
                $pageItemIds = $page->page_items()->pluck('id')->toArray();
                $pageItems = $pageItems->whereIn('subject_id', $pageItemIds);
            }

            $pageItemIds = $pageItems->pluck('id')->toArray();

            $query = $query->whereIn('id', array_merge($pageIds, $pageItemIds));
        }

        return $query;
    }

    /**
     * Filter Subject
     * @param  QueryBuilder $query   
     * @param  string $param  
     * @param  string $subject 
     * @return Query Builder          
     */
    protected function filterSubject($query, $param, $subject, $id = false) 
    {
        if ($this->request->filled($param)) {
            $filters = [
                'subject_type' => $subject,
            ];

            if ($id) {
                $filters = array_merge($filters, [
                    'subject_id' => $id,
                ]);
            } else {
                if ($this->request->filled('id')) {
                    $filters = array_merge($filters, [
                        'subject_id' => $this->request->input('id'),
                    ]);
                }
            }

            $query = $query->where($filters);
        }

        return $query;
    }

    /**
     * Additional Query for when being extended
     * @param  QueryBuilder $query
     * @return QueryBuilder
     */
    public function additionalQuery($query) 
    {
        return $query;
    }

    /**
     * Custom formatting of data
     * 
     * @param Illuminate\Support\Collection $items
     * @return array $result
     */
    public function formatData($items) 
    {
        $result = [];

        foreach($items as $item) {
            $data = $this->formatItem($item);

            array_push($result, array_merge($data, [
                'id' => $item->id,
                'name' => $item->renderName(),
                'caused_by' => $item->renderCauserName(),
                'show_causer' => $item->renderCauserShowUrl(),
                'subject_type' => $item->renderSubjectType(),
                'subject_name' => $item->renderSubjectName(),
                'created_at' => $item->renderDate(),
            ]));
        }

        return $result;
    }

    /**
     * Additional property when extended
     * 
     * @param  App\Contracts\AvailablePosition
     * @return array
     */
    protected function formatItem($item) 
    {
        return [
            'showUrl' => $item->renderShowUrl(),
        ];
    }
}

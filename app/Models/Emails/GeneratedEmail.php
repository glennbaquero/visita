<?php

namespace App\Models\Emails;

use App\Helpers\StringHelpers;

use App\Extenders\Models\BaseModel as Model;

class GeneratedEmail extends Model
{
	const BOOKING_NOTIFICATION = 'Booking notification';
	const GENERATED_QR_NOTIFICATION = 'Generating QR notification';
	const NEW_BOOKING_NOTIFICATION = 'New booking notification';
	const RESERVATION_REJECTED = 'Rejected reservation';
	const RESERVATION_APPROVED = 'Approved reservation';

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['title', 'notification_type', 'message'])
    {
        $vars = $request->only($columns);

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        return $item;
    }

    /**
     * @Getters
     */
    public static function getTypes() {
        return [
            ['value' => static::BOOKING_NOTIFICATION, 'label' => 'Booking notification', 'class' => 'bg-info'],
            ['value' => static::GENERATED_QR_NOTIFICATION, 'label' => 'Generating QR notification', 'class' => 'bg-success'],
            ['value' => static::NEW_BOOKING_NOTIFICATION, 'label' => 'New booking notification', 'class' => 'bg-warning'],
            ['value' => static::RESERVATION_REJECTED, 'label' => 'Rejected reservation', 'class' => 'bg-warning'],
            ['value' => static::RESERVATION_APPROVED, 'label' => 'Approved reservation', 'class' => 'bg-warning'],
        ];
    }

    /**
     * @Render
     */
    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.generated-emails.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.generated-emails.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.generated-emails.restore', $this->id);
    }
}

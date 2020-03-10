<?php

namespace App\Models\Invoices;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

use App\Models\Books\Book;
use App\Models\Users\User;
use App\Traits\ArchiveableTrait;
use App\Traits\HelperTrait;
use App\Traits\DateTrait;
use App\Traits\PaginationTrait;
use App\Traits\ArrayFormatterTrait;

class Invoice extends Model
{
    use ArchiveableTrait, HelperTrait, DateTrait, LogsActivity, PaginationTrait, ArrayFormatterTrait;

    protected $guarded = [];

    protected static $logAttributes = [];
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = false;

    protected $appends = ['invoice_status'];

    public function book() {
    	return $this->belongsTo(Book::class)->withTrashed();
    }

    // public function user() {
    // 	return $this->belongsTo(User::class);
    // }
    
    public function bookable() 
    {
        return $this->morphTo();
    }

    public function renderStatusLabel() {
    	$label = 'Pending';
    	if($this->is_approved && !$this->is_paid) $label = 'Payment Pending';
    	if(!$this->is_approved && !$this->is_paid) $label = 'For Approval';
    	if($this->is_approved && $this->is_paid) $label = 'Paid';
        if($this->deleted_at) $label = 'Rejected';
    	return $label;
    }

    public function renderStatusClass() {
    	$class = 'pending';
    	if($this->is_approved && !$this->is_paid) $class = 'payment-pending';
    	if(!$this->is_approved && !$this->is_paid) $class = 'for-approval';
        if($this->is_approved && $this->is_paid) $class = 'confirmed';
    	if($this->deleted_at) $class = 'rejected';
    	return $class;
    }

    public function renderArchiveUrl()
    {
    	return route('admin.invoices.archive', $this->id);
    }

    public function renderRejectDepositSlipUrl() 
    {
    	return route('admin.invoices.reject.deposit', $this->id);
    }

    public function renderInitialPaymentUrl() 
    {
        return route('admin.invoices.initial-paid', $this->id);
    }

    public function renderFinalPaymentUrl() 
    {
        return route('admin.invoices.final-paid', $this->id);
    }

    public function renderFullFinalPaymentUrl() 
    {
        return route('admin.invoices.full-final-paid', $this->id);
    }

    public function renderShowButtonTypeForBankDeposit() 
    {
        $btn = null;

        if(!$this->is_paypal_payment && !$this->is_fullpayment && $this->is_firstpayment_paid && !$this->is_paid) {
            $btn = 'final_button-show';
        } elseif (!$this->is_paypal_payment && !$this->is_fullpayment && $this->is_firstpayment_paid == 0) {
            $btn = 'initial_button-show';
        } elseif(!$this->is_paypal_payment && $this->is_fullpayment == 1 && $this->is_paid == 0) {
            $btn = 'fullpayment-final_button-show';
        }

        return $btn;
    }

    public function renderPaymentStatus() {
        $label = null;
        if($this->is_firstpayment_paid && !$this->is_secondpayment_paid && !$this->is_paid && !$this->is_fullpayment) {
            $label = 'Initial Payment Paid';
        } elseif ($this->is_firstpayment_paid && $this->is_secondpayment_paid && $this->is_paid) {
            $label = 'Fully Paid';
        } elseif (!$this->is_approved) {
            $label = 'For Approval';
        } elseif ($this->is_approved && !$this->is_paid && !$this->is_firstpayment_paid || $this->is_fullpayment) {
            $label = 'No transaction found';
        }
        if($this->deleted_at) {
            $label = 'Rejected';
        }

        return $label;
    }

    public function getInvoiceStatusAttribute() {
        $status = null;
        if($this->is_firstpayment_paid && !$this->is_secondpayment_paid && !$this->is_paid && !$this->is_fullpayment) {
            $status = 2;
        } elseif ($this->is_firstpayment_paid && $this->is_secondpayment_paid && $this->is_paid) {
            $status = 1;
        } elseif (!$this->is_approved) {
            $status = 3;
        }

        if($this->deleted_at) {
            $status = 4;
        }

        return $status;
    }
}

<?php

namespace App\Models\Invoices;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Books\Book;
use App\Models\Users\User;

class Invoice extends Model
{
    public function book() {
    	return $this->belongsTo(Book::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function renderStatusLabel() {
    	$label = 'Pending';
    	if($this->is_approved && !$this->is_paid) $label = 'Payment';
    	if(!$this->is_approved && !$this->is_paid) $label = 'Confirmation';
    	if($this->is_approved && $this->is_paid) $label = 'Reserved';
    	return $label;
    }

    public function renderStatusClass() {
    	$class = 'pending';
    	if($this->is_approved && !$this->is_paid) $class = 'pending';
    	if(!$this->is_approved && !$this->is_paid) $class = 'confirmed';
    	if($this->is_approved && $this->is_paid) $class = 'confirmed';
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
}

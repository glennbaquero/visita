<?php

namespace App\Models\Payments;

use App\Extenders\Models\BaseModel as Model;

class Payment extends Model
{

    const FIXED = 'FIXED';
    const PERCENTAGE = 'PERCENTAGE';
    const COMPARISON = 'COMPARISON';

	/**
	 * Get the indexable data array for the model.
	 *
	 * @return array
	 */
	public function toSearchableArray()
	{
	    $searchable = [
	        'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
	        'fixed_amount' => $this->fixed_amount,
	        'percentage_amount' => $this->getPercentageAmount(),
	    ];
	    
	    return $searchable;
	}


    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'fixed_amount', 'percentage_amount', 'type', 'code'])
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
    * Getters 
    */
   
   /**
    * Get fee type
    * 
    * @return Array
    */
   public static function getFeeTypes()
   {
       return collect([
           ['label' => 'FIXED', 'value' => PAYMENT::FIXED],
           ['label' => 'PERCENTAGE', 'value' => PAYMENT::PERCENTAGE],
           ['label' => 'COMPARISON', 'value' => PAYMENT::COMPARISON]
       ]);
   }


    /**
     * @Render
     */
    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.payments.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.payments.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.payments.restore', $this->id);
    }

    public function getPercentageAmount() {
        $amount = $this->percentage_amount;
        $amount /= 100;

    	return $amount;
    }
}

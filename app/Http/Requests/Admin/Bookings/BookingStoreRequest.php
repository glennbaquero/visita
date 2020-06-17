<?php

namespace App\Http\Requests\Admin\Bookings;

use Illuminate\Foundation\Http\FormRequest;

class BookingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'scheduled_at' => 'required',
            'allocation_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'nationality' => 'required',
            'email' => 'required',
            'contact_number' => 'required',
            'emergency_contact_number' => 'required',
            'birthdate' => 'required',
            'gender' => 'required',
            'visitor_type_id' => 'required',
            'guest_first_name.*' => 'required',
            'guest_last_name.*' => 'required',
            'guest_nationality.*' => 'required',
            'guest_email.*' => 'required',
            'guest_contact_number.*' => 'required',
            'guest_emergency_contact_number.*' => 'required',
            'guest_birthdate.*' => 'required',
            'guest_gender.*' => 'required',
            'guest_visitor_type.*' => 'required'
        ];
    }

    public function messages() 
    {
        return [
            'scheduled_at.required' => 'Please select schedule date.',
            'allocation_id.required' => 'Please experience.',
            'first_name.required' => 'Main contact first name field is required.',
            'last_name.required' => 'Main contact last name field is required.',
            'nationality.required' => 'Main contact nationality field is required.',
            'email.required' => 'Main contact email field is required.',
            'contact_number.required' => 'Main contact contact number field is required.',
            'emergency_contact_number.required' => 'Main contact emergency contact number field is required.',
            'birthdate.required' => 'Main contact birthday field is required.',
            'gender.required' => 'Main contact gender field is required.',
            'visitor_type_id.required' => 'Main contact visitor type field is required.',
            'guest_first_name.*.required' => 'Guest first name field is required.',
            'guest_last_name.*.required' => 'Guest last name field is required.',
            'guest_nationality.*.required' => 'Guest nationality field is required.',
            'guest_email.*.required' => 'Guest email field is required.',
            'guest_contact_number.*.required' => 'Guest contact number field is required.',
            'guest_emergency_contact_number.*.required' => 'Guest emergency contact number field is required.',
            'guest_birthdate.*.required' => 'Guest birthday field is required.',
            'guest_gender.*.required' => 'Guest gender field is required.',
            'guest_visitor_type.*.required' => 'Guest visitor type field is required.',
        ];
    }
}

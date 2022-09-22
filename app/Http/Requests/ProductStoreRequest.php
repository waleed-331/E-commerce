<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ProductStoreRequest extends FormRequest
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
            'name' => ['required','string'],
            'image' => ['required','file'],
            'expiration_date' => ['required','date'],
            'quantity' => ['required','int'],
            'category_id' => ['required','int'],
            'phone' => ['required','min:10'],
            'facebook' => ['required','string'],
            'price' => ['required','int'],
            'details'=>['required','string'],
            'periods'=>['required' , 'array' ,'size:2'],
            'periods.0'=>['required'  ,'int'],
            'periods.1'=>['required' ,'lt:periods.0','int' ],
            'discounts' => ['required' ,'array' ,'size:3'],
            'discounts.0' => ['required','lt:1'],
            'discounts.1' => ['required','gt:discounts.0','lt:1' ],
            'discounts.2' => ['required', 'gt:discounts.1','lt:1'],
        ];
    }
    public function withValidator(Validator $validator)
    {
        $validator->validate();
        $validator->after(function ($validator) {
            //if(Carbon::parse($this->expiration_date)->subDays($this->periods[0])->isBefore(Carbon::today()))
            if(Carbon::parse($this->expiration_date)->subDays($this->periods[0]) <= today())
            {
                $validator->errors()->add('periods', 'first period is not valid');
            }
        });
    }
}


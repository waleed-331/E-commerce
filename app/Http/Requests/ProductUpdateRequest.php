<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => ['required'],
            'image' => ['required','file'],
            'quantity' => ['required','int'],
//            'category_id' => ['required'],
            'phone' => ['required','int','min:10'],
            'facebook' => ['required','string'],
            'price' => ['required','int'],
//            'periods'=>['required' , 'array' ,'size:2'],
            'periods.0'=>['required','int'],
            'periods.1'=>['required','lt:periods.0','int' ],
            'details'=>['required','string'],
  //          'discounts' => ['required' ,'array','size:3'],
            'discounts.0' => ['required','lt:1'],
            'discounts.1' => ['required','gt:discounts.0','lt:1' ],
            'discounts.2' => ['required', 'gt:discounts.1','lt:1'],
        ];
    }
}

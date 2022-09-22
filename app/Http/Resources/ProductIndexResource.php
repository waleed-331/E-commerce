<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductIndexResource extends JsonResource
{
    /**
     * @var mixed
     */
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        // return parent::toArray($request);

        return[
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'name'=>$this->name,
            'image'=>Storage::disk('public')->url($this->image),
            'expiration_date'=>$this->expiration_date,
            'periods'=>$this->periods,
            'quantity'=>$this->quantity,
            'category_id'=>$this->category_id,
            'phone'=>$this->phone,
            'details'=>$this->details,
            'facebook'=>$this->facebook,
            'price'=>$this->price,
            'discounts'=>$this->discounts,
            'views'=>$this->views,
            'price_after_discount'=>$this->price_after_discount,

        ];
    }
}

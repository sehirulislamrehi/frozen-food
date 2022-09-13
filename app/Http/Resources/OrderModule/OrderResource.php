<?php

namespace App\Http\Resources\OrderModule;

use App\Models\OrderModule\OrderServices;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'order_no' => $this->order_no,
            'customer_name' => $this->name,
            'customer_email' => $this->email,
            'customer_phone' => $this->phone,
            'postal_code' => $this->postal_code,
            'location' => $this->location,
            'address_details' => $this->address_details,
            'address_type' => $this->address_type,
            'timing' => $this->timing,
            'total' => $this->total,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at->toDayDateTimeString(),
            'services' => OrderServices::where("order_id", $this->id)->select("service_id","price","instruction")->with("service")->get(), 
        ];
    }
}

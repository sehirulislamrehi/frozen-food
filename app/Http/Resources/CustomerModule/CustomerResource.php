<?php

namespace App\Http\Resources\CustomerModule;

use App\Models\OrderModule\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image ? asset('images/customer/'.$this->image) : asset('images/profile/user.png'),
            'phone' => $this->phone ,
            'email' => $this->email,
            'address' => $this->address,
            'is_active' => $this->is_active,
            'is_verified' => $this->is_verified,
            'remember_token' => $this->remember_token
        ];
    }
}

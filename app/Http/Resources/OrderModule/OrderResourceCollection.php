<?php

namespace App\Http\Resources\OrderModule;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderResourceCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\OrderModule\OrderResource';

    public function toArray($request)
    {
        return[
            'data' => $this->collection
        ];
    }
}

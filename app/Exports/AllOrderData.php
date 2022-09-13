<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AllOrderData implements FromView
{
    public $data;

    public function view(): View
    {
        return view('backend.modules.order_module.all_order.export.all_order_data', [
            'datas' => $this->data,
        ]);
    }

    public function getDownloadByQuery($data)
    {
        $this->data = $data;

        return $this;
    }
}

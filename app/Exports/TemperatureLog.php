<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TemperatureLog implements FromView
{
    public $temperature_logs;
    public $total_freezer;

    public function view(): View
    {
        return view('backend.modules.log_sheet_module.temperature_log.export.date_to_date', [
            'temperature_logs' => $this->temperature_logs,
            'total_freezer' => $this->total_freezer,
        ]);
    }

    public function getDownloadByQuery($data,$data2)
    {
        $this->temperature_logs = $data;
        $this->total_freezer = $data2;
        return $this;
    }

}

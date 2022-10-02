<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    public function model(array $row)
    {
        return $row;
    }
}

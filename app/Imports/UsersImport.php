<?php

namespace App\Imports;

use App\Models\Taxcollect;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        //prd($row);
        return new Taxcollect([
            'technical_area_id'           => $row['technical_area_id'],
            'health_indicator_id'         => $row['health_indicator_id'],
            'health_indicator_measure_id' => $row['health_indicator_measure_id'],
            'level_type'                  => $row['level_type'],
        ]);
    }
}

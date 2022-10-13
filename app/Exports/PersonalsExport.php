<?php

namespace App\Exports;

use App\Models\Personal;
use App\Http\Controllers\PersonalController;
// use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Queue\SerializesModels;

class PersonalsExport implements FromArray, shouldQueue
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $Data;

    public function __construct($data)
    {
        $this->Data = $data;
    }

    public function array(): array
    {
        return $this->Data;
    }
}

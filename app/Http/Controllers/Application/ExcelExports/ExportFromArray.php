<?php

namespace App\Http\Controllers\Application\ExcelExports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class ExportFromArray implements FromCollection, WithHeadings
{
    //

    public function __construct($array)
    {
        $this->collection = collect($array);
    }

    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {

        $headings_arr = [];
        foreach($this->collection[0] as $name=>$value){
            $headings_arr[] = $name;
        }
        //dd($headings_arr);
        return $headings_arr;
    }
}
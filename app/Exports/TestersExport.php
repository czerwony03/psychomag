<?php

namespace App\Exports;

use App\Models\Tester;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TestersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tester::with(['tests' => function ($query) {
            $query->orderBy('test_id');
        }])->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'UUID',
            'Utworzony',
            'Aktualizacja',
            /*'C4',
            'C5',
            'C6',
            'C7',*/
        ];
    }

    public function map($tester): array
    {
        
        return [
            $tester->id,
            $tester->uuid,
            $tester->created_at,
            $tester->updated_at,
        ];
    }
}

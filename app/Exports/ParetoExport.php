<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class ParetoExport implements WithMultipleSheets
{
    protected $salesData;

    public function __construct($salesData)
    {
        $this->salesData = $salesData;
    }

    public function sheets(): array
    {
        $allSalesData = collect($this->salesData);

        // Filtering data for Pareto categories
        $paretoA = $allSalesData->where('total_sold', '>', 10);
        $paretoB = $allSalesData->where('total_sold', '>', 7);
        $paretoC = $allSalesData->where('total_sold', '>', 5);
        $paretoD = $allSalesData->where('total_sold', '>', 3);
        $paretoE = $allSalesData->where('total_sold', '>', 1);

        return [
            new SalesSheet($allSalesData, 'Semua Obat'),
            new SalesSheet($paretoA, 'Pareto A'),
            new SalesSheet($paretoB, 'Pareto B'),
            new SalesSheet($paretoC, 'Pareto C'),
            new SalesSheet($paretoD, 'Pareto D'),
            new SalesSheet($paretoE, 'Pareto E'),
        ];
    }
}

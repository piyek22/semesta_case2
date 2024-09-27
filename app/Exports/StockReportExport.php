<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StockReportExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $stockData = DB::table('master_item')
            ->select('kode_item', 'satuan','nama_item', 'harga_beli','stok')
            ->get();

        return [
            'All Stock' => new StockSheet($stockData),
            'Stock < 10' => new StockSheet($stockData->where('stok', '<', 10)),
            'Stock = 0' => new StockSheet($stockData->where('stok', '=', 0)),
            'Stock > 10' => new StockSheet($stockData->where('stok', '>', 10)),
        ];
    }
}

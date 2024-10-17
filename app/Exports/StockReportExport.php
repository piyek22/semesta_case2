<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StockReportExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        // Data seluruh obat
        $allStockData = DB::table('master_item')
            ->select('kode_item', 'satuan', 'nama_item', 'harga_beli', 'stok')
            ->get();

        // Data obat yang stok nya kurang dari 10
        $lowStockData = DB::table('master_item')
            ->where('stok', '<', 10)
            ->select('kode_item', 'satuan', 'nama_item', 'harga_beli', 'stok')
            ->get();

        // Data obat yang stok nya 0
        $zeroStockData = DB::table('master_item')
            ->where('stok', '=', 0)
            ->select('kode_item', 'satuan', 'nama_item', 'harga_beli', 'stok')
            ->get();

        // Data obat yang stok nya lebih dari 10
        $highStockData = DB::table('master_item')
            ->where('stok', '>', 10)
            ->select('kode_item', 'satuan', 'nama_item', 'harga_beli', 'stok')
            ->get();

        return [
            new StockSheet($allStockData, 'All Stock'),
            new StockSheet($lowStockData, 'Stock < 10'),
            new StockSheet($zeroStockData, 'Stock = 0'),
            new StockSheet($highStockData, 'Stock > 10'),
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\StockReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class StockReportController extends Controller
{
    public function showStockReport()
    {
        // Query the database to retrieve the stock data
        $stockData = DB::table('master_item')
            ->select('kode_item', 'satuan','nama_item', 'harga_beli','stok')
            ->get();

        // Return the view with stock data
        return view('stock_report', compact('stockData'));
    }

    public function exportStockReport(Request $request)
    {
        // Download the Excel file with the stock report
        return Excel::download(new StockReportExport, 'stock_report.xlsx');
    }
}

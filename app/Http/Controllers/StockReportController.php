<?php

namespace App\Http\Controllers;

use App\Exports\StockReportExport;
use App\Exports\ParetoExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class StockReportController extends Controller
{
    public function showStockReport()
    {
        $stockData = DB::table('master_item')
            ->select('kode_item', 'satuan', 'nama_item', 'harga_beli', 'stok')
            ->get();

        return view('stock_report', compact('stockData'));
    }

    public function exportStockReport(Request $request)
    {
        return Excel::download(new StockReportExport, 'stock_report.xlsx');
    }

    public function exportPareto(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ambil data penjualan berdasarkan tanggal
        $salesData = DB::table('penjualan')
            ->join('penjualan_detail', 'penjualan.id', '=', 'penjualan_detail.id_penjualan')
            ->select('penjualan_detail.kode_item', DB::raw('SUM(penjualan_detail.kuantiti) as total_sold'))
            ->whereBetween('penjualan.tanggal', [$startDate, $endDate])
            ->groupBy('penjualan_detail.kode_item')
            ->get();

        // Mengelompokkan data ke dalam kategori Pareto
        $paretoA = $salesData->where('total_sold', '>', 10);
        $paretoB = $salesData->where('total_sold', '>', 7);
        $paretoC = $salesData->where('total_sold', '>', 5);
        $paretoD = $salesData->where('total_sold', '>', 3);
        $paretoE = $salesData->where('total_sold', '>', 1);

        // Menggunakan Excel untuk mengunduh file
        return Excel::download(new ParetoExport($paretoA, $paretoB, $paretoC, $paretoD, $paretoE), 'pareto_report.xlsx');
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\StockReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class StockReportController extends Controller
{
    // Menampilkan halaman laporan stok obat
    public function showStockReport()
    {
        // Mengambil data stok dari tabel master_item
        $stockData = DB::table('master_item')
            ->select('kode_item', 'satuan', 'nama_item', 'harga_beli', 'stok')
            ->get();

        // Menampilkan view laporan stok obat
        return view('stock_report', compact('stockData'));
    }

    // Fungsi untuk mengekspor data stok obat ke Excel
    public function exportStockReport(Request $request)
    {
        // Mengekspor file Excel
        $fileName = 'stock_report.xlsx';

        // Menampilkan pesan sukses setelah download
        session()->flash('success', 'Stok obat berhasil di-export.');

        return Excel::download(new StockReportExport, $fileName);
    }
}

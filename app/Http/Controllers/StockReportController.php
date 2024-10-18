<?php

namespace App\Http\Controllers;

use App\Exports\StockReportExport;
use App\Exports\ParetoExport;
use App\Exports\PermintaanBarangExport; // Pastikan ini ada
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

    public function exportPermintaanBarang(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ambil data dari master_item dan penjualan
        $items = DB::table('master_item')
        ->leftJoin('penjualan_detail', 'master_item.kode_item', '=', 'penjualan_detail.kode_item')
        ->leftJoin('penjualan', 'penjualan_detail.id_penjualan', '=', 'penjualan.id') // Tambahkan join ke tabel penjualan
        ->select(
            'master_item.nama_item',
            'master_item.stok',
            DB::raw('COALESCE(SUM(penjualan_detail.kuantiti), 0) as total_penjualan'),
            'master_item.satuan'
        )
        ->whereBetween('penjualan.tanggal', [$startDate, $endDate]) // Gunakan kolom tanggal dari tabel penjualan
        ->groupBy('master_item.kode_item')
        ->get();

        $data = $items->map(function ($item) {
            $selisih = $item->stok - $item->total_penjualan;

            // Hitung jumlah order
            if ($item->total_penjualan > $item->stok) {
                $jumlah_order = $selisih * 2;
            } else {
                $jumlah_order = $selisih * 1;
            }

            // Pastikan jumlah order tidak melebihi sisa stok
            if ($jumlah_order > $item->stok) {
                $jumlah_order = $item->stok;
            }

            return [
                'Nama Item' => $item->nama_item,
                'Sisa Stok' => $item->stok,
                'Total Penjualan' => $item->total_penjualan,
                'Satuan' => $item->satuan,
                'Selisih Stok' => $selisih,
                'Jumlah Order' => $jumlah_order,
            ];
        });

        // Download file permintaan barang
        return Excel::download(new PermintaanBarangExport($data), 'permintaan_barang.xlsx');
         // Menambahkan notifikasi setelah ekspor berhasil
    session()->flash('success', 'Permintaan barang berhasil di export.');

    // Kembalikan response agar pengguna tetap berada di halaman yang sama
    return redirect()->back();
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockReportController;

// Rute untuk menampilkan halaman laporan stok obat
Route::get('/stock-report', [StockReportController::class, 'showStockReport'])->name('stock.report');

// Rute untuk mengekspor stok obat
Route::post('/export-stock', [StockReportController::class, 'exportStockReport'])->name('export.stock');

// Rute untuk mengekspor data pareto
Route::post('/export-pareto', [StockReportController::class, 'exportPareto'])->name('export.pareto');

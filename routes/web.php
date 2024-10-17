<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockReportController;



Route::get('/stock-report', [StockReportController::class, 'showStockReport'])->name('stock.report');
Route::post('/export-stock', [StockReportController::class, 'exportStockReport'])->name('export.stock');


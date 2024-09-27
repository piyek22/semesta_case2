<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockReportController;
// routes/web.php

Route::get('/stock-report', [StockReportController::class, 'showStockReport'])->name('stock.report');
Route::get('/export-stock', [StockReportController::class, 'exportStockReport'])->name('export.stock');

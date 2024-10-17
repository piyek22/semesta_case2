<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class StockSheet implements FromCollection, WithTitle
{
    protected $data;
    protected $title;

    public function __construct($data, $title)
    {
        $this->data = $data;
        $this->title = $title;
    }

    // Mengambil data untuk ditampilkan di sheet
    public function collection()
    {
        return $this->data;
    }

    // Mengatur judul sheet
    public function title(): string
    {
        return $this->title;
    }
}

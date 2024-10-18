<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PermintaanBarangExport implements FromCollection, WithHeadings, WithTitle
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    // Mengembalikan koleksi data untuk diekspor
    public function collection()
    {
        return collect($this->data); // Mengembalikan data sebagai koleksi
    }

    // Menentukan judul kolom di Excel
    public function headings(): array
    {
        return [
            'Nama Item',
            'Sisa Stok',
            'Total Penjualan',
            'Satuan',
            'Selisih Stok',
            'Jumlah Order'
        ];
    }

    // Menentukan nama sheet
    public function title(): string
    {
        return 'Permintaan Barang';
    }
}

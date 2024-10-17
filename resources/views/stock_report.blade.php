<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Obat</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Laporan Stok Obat</h3>
                <form action="{{ route('export.stock') }}" method="POST" class="float-end">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Export Excel Stok Obat</button>
                </form>
            </div>

            <!-- Notifikasi umum -->
            @if (Session::has('success'))
            <div class="alert alert-success text-center mt-3">
                {{ Session::get('success') }}
            </div>
            @endif

            <!-- Tabel data stok obat -->
            <div class="card-body">
                <table class="display table table-bordered table-striped" id="stock-table">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Item</th>
                            <th>Nama Item</th>
                            <th>Satuan</th>
                            <th>Harga Beli</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stockData as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode_item }}</td>
                            <td>{{ $item->nama_item }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ $item->harga_beli }}</td>
                            <td>{{ $item->stok }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Load jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.7/js/dataTables.js"></script>

    <script>
        $(document).ready(function () {
            $('#stock-table').DataTable({
                "language": {
                    "emptyTable": "Tidak ada data obat ditemukan"
                }
            });
        });
    </script>
</body>
</html>

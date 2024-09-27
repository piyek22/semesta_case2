<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Report</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-header {
            background-color: #007bff;
            color: white;
        }
        .btn-export {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Laporan Stock Obat</h1>

    <!-- Table to display stock data -->
    <table class="table table-striped table-bordered" id="stockTable">
        <thead class="table-header">
            <tr>
                <th>No</th>
                <th>Kode Item</th>
                <th>Satuan</th>
                <th>Nama Item</th>
                <th>Harga beli</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockData as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_item }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->nama_item }}</td>
                    <td>{{ $item->harga_beli }}</td>
                    <td>{{ $item->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Button to export the report -->
    <div class="text-center btn-export">
        <a href="{{ route('export.stock') }}" class="btn btn-primary">Export Stock Obat</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#stockTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
    });
</script>
</body>
</html>

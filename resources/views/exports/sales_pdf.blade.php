// resources/views/exports/sales_pdf.blade.php
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        /* Tambahkan CSS untuk tampilan PDF di sini */
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Laporan Penjualan {{ $filter_label }}</h1>
    <p>Periode: {{ $start_date ?? 'Semua' }} s/d {{ $end_date ?? 'Data' }}</p>

    <table>
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Total Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale['id'] }}</td>
                <td>{{ $sale['date_formatted'] }}</td>
                <td>{{ $sale['customer'] }}</td>
                <td>{{ $sale['total_formatted'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>Total Pendapatan: {{ $total_revenue }}</p>
    <p>Total Pesanan: {{ $total_orders }}</p>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Faktur Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
    </style>
</head>
<body>
    <h2>Faktur Transaksi #{{ $order->id }}</h2>

    <p>Nama Member: {{ $order->member->name }}</p>
    <p>Tanggal: {{ $order->created_at }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $row)
            <tr>
                <td>{{ $row->product->name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ number_format($row->price) }}</td>
                <td>{{ number_format($row->qty * $row->price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

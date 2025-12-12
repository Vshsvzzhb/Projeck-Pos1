@extends('templates.layout')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-body">
      <h4>Invoice: {{ $order->invoice }}</h4>
      <p><strong>Pelanggan:</strong> {{ $order->member->name ?? '-' }}</p>
      <p><strong>Tanggal:</strong> {{ $order->created_at }}</p>

      <table class="table table-sm">
        <thead>
          <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
          @foreach($details as $d)
          <tr>
            <td>{{ $product[$d->product_id]->name ?? $d->product_id }}</td>
            <td>{{ $d->quantity }}</td>
            <td>{{ number_format($d->price, 0, ',', '.') }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" class="text-end"><strong>Total</strong></td>
            <td>{{ number_format($order->total, 0, ',', '.') }}</td>
          </tr>
        </tfoot>
      </table>

      <div class="mt-3">
        <a href="{{ url('order') }}" class="btn btn-secondary btn-sm">Kembali</a>
        <button id="print-now" class="btn btn-primary btn-sm">Print</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
  // trigger print automatically when page loads
  window.addEventListener('load', function() {
    // small delay to allow layout
    setTimeout(function() {
      window.print()
    }, 300)
  })

  // also allow manual print
  document.getElementById('print-now').addEventListener('click', function() {
    window.print()
  })
</script>
@endpush
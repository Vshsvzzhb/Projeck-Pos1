@extends('templates.layout')
@section('content')
@foreach($categories as $category)
<h3 class="mt-4 mb-3 text-primary">{{ $category->name }}</h3>
<div class="row row-cols-1 row-cols-md-2 g-4 item-product">
  @foreach ($category->product as $product)
  <div class="col">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <input type="hidden" class="id_product" value="{{ $product->id }}"><br>
        <h3>Rp. {{ number_format($product->price, 0, ',', '.')}}</h3>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endforeach
@endsection
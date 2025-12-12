@foreach($categories as $category)
<h5 class="mb-2 mt-3 text-secondary">{{ $category->name }}</h5>
<div
  class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2 item-product">
  @foreach ($category->product as $product)
  <div class="col">
    <div class="card h-100 shadow-sm">
      <div
        class="card-body p-2 d-flex flex-column justify-content-between">
        <div>
          {{-- product name above price; allow wrapping instead of truncation --}}
          <h6
            class="card-title mb-1"
            style="margin: 0; font-size: 0.95rem">
            {{ $product->name }}
          </h6>
        </div>
        <div class="text-muted small">
          Rp {{ number_format($product->price , 2, ',', '.') }}
        </div>
        {{-- store numeric price on hidden input for JS to read easily --}}
        <input type="hidden" class="id_product" value="{{ $product->id }}" data-price="{{ $product->price }}">
        <div class="d-flex justify-content-end align-items-center mt-2">
          <button
            class="btn btn-sm btn-outline-primary btn-add"
            title="Tambah Ke Keranjang">
            <span class="small">Add</span>
          </button>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endforeach
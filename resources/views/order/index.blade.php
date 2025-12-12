@extends('templates.layout')
@section('content')
<div class="col-8">
  @include('order.form')
</div>
<div class="col-4">
  @include('order.cart')
</div>
@endsection

@push('script')
@include('order.script')
@endpush
@extends('layouts.app')

@section('contents')
    <h1 class="mb-0">Edit Product</h1>
    <hr>
    <form class="was-validated" action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $product->name }}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Quantity</label>
                <input type="number" min="0" name="quantity" class="form-control" placeholder="Quantity" value="{{ $product->quantity }}" required>
            </div>
            <div class="col">
                <label class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" value="{{ $product->price }}"y>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection
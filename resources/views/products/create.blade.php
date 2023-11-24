@extends('layouts.app')

@section('contents')
    <h1 class="mb-0">Add Product</h1>
    <hr>
    <form class="was-validated" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="number" min="0" name="quantity" class="form-control" placeholder="Quantity" required>
            </div>
            <div class="col">
                <input type="number" step="0.01" name="price" class="form-control" placeholder="Price">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection

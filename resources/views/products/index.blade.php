@extends('layouts.app')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">List of your Products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
    </div>
    <hr>
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table">
        <thead class="table">
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->count() > 0)
                @foreach ($products as $product)
                    <tr>
                        <td class="align-middle">{{ $product->name }}</td>
                        <td class="align-middle">{{ $product->quantity }}</td>
                        <td class="align-middle">{{ $product->price }}</td>
                        <td class="align-middle">
                            <a href="{{ route('products.show', $product->id) }}" type="button"
                                class="btn btn-secondary">Detail</a>
                            <a href="{{ route('products.edit', $product->id) }}" type="button"
                                class="btn btn-warning">Edit</a>
                            {{-- <form action="{{ route('products.destroy', $product->id) }}" method="POST" type="button"
                                class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger m-0">Delete</button>
                            </form> --}}
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $product->id }}">Delete</button>
                        </td>
                        <!-- Modal de confirmación -->
                        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete <b>{{ $product->name }}</b>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Product not found</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $products->links('vendor.pagination.bootstrap-5') }}
@endsection

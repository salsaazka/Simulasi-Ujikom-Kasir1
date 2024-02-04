@extends('layouts.index')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('product.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" id="" class="form-control" placeholder="Input Name">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Price</label>
                    <input type="number" name="price" id="" class="form-control" placeholder="Input Price">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Stok</label>
                    <input type="number" name="stok" id="" class="form-control" placeholder="Input Stok">
                </div>
                <button
                    type="submit"
                    class="btn text-white mb-5"
                    style="background-color: #55D090"
                >
                    Submit
                </button>
            </form>
        </div>
    </div>
@endsection
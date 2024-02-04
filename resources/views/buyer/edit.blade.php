@extends('layouts.index')

@section('content')
    <div class="card">
        <div class="card-body">
        <form action="{{ route('buyer.update', $dataBuyer->id) }}" method="POST">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" value="{{ $dataBuyer->name }}" id="" class="form-control" placeholder="Input Name">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">No Telp</label>
                    <input type="number" name="no_telp" value="{{ $dataBuyer->no_telp }}" id="" class="form-control"  placeholder="Input No Telp">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Address</label>
                    <input type="text" name="address" id="" value="{{ $dataBuyer->address }}"  class="form-control" placeholder="Input Address">
                </div>-
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
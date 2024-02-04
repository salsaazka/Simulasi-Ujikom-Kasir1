@extends('layouts.index')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Data table</h6>
                        <a href="{{ route('sale.create') }}" class="btn add-new btn-success m-1 float-end"><i class="fa-solid fa-plus"></i></a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name Buyer</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Price</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($dataSale as $sale)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $sale->buyer->name }}</td>
                                            <td>{{ $sale->created_at }}</td>
                                            <td>{{ $sale->total_price }}</td>
                                            {{-- <td>{{ $sale->product->total_produk }}</td> --}}
                                            <td class="d-flex">
                                                <a href="{{ route('sale.edit', $sale->id) }}" class="btn btn-warning" style="margin-right: 5px"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <form action="/sale/delete/{{ $sale->id }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" style="margin-right: 5px"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal{{ $sale->id }}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                @php $filteredDetails = $dataSale->filter(function ($item) use ($sale) {
                                                    return $item->sale_id == $sale->id;
                                                }); @endphp 

                                                <div class="modal fade" id="myModal{{ $sale->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Detail Sale</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>

                                                            {{-- <div class="modal-body">
                                                                <p><strong>Total Produk:</strong>
                                                                    {{ $filteredDetails->total_produk }}</p>
                                                                <p><strong>Subtotal:</strong> {{ $filteredDetails->subtotal }}</p>
                                                                <p><strong>Product Name:</strong>
                                                                    {{ $filteredDetails->name }}</p>
                                                                <p><strong>Sale Date:</strong> {{ $filteredDetails->created_at }}
                                                                </p>
                                                            </div> --}}
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
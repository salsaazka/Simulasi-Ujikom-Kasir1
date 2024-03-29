@extends('layouts.index')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                        <h6>Data table</h6>
                        <a href="{{ route('sale.create') }}" class="btn add-new btn-success m-1 float-end"><i
                                class="fa-solid fa-plus"></i></a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Name Buyer</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Date</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Price</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Produk</th>
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
                                                <a href="{{ route('sale.edit', $sale->id) }}" class="btn btn-warning"
                                                    style="margin-right: 5px"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <form action="/sale/delete/{{ $sale->id }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger"
                                                        style="margin-right: 5px"><i class="fa-solid fa-trash"></i></button>
                                                </form>
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editModal" data-total_price="{{ $sale->total_price }}">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

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
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" id="modal-content">

                {{-- content here --}}

            </div>
        </div>
    </div>
    <!-- End Modal Edit -->
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script>
        $('#editModal').on('shown.bs.modal', function(e) {
            var html = `
            <div class="modal-content" id="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Detail Sale</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="edit">
                        <div class="mb-3">
                            <label for="total_price" class="form-label">Subtotal</label>
                            <input type="text" class="form-control" id="total_price" aria-describedby="Subtotal"
                                placeholder="..." name="Subtotal" value="${$(e.relatedTarget).data('total_price')}">
                        </div>

                    </div>
                </div>
                `;

            $('#modal-content').html(html);

        });
    </script>
@endsection

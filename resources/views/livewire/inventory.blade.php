    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section my-4">LIST BARANG</h2>
            </div>
            <div class="d-flex justify-content-end mb-3 gap-2">
                <a href="{{ url('inventory/create') }}" class="btn btn-dark d-none d-sm-inline">
                    <i class="bi bi-plus"></i> New
                </a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                    Import
                </button>
                <a href="{{ route('export-excel-for-page', ['page' => $inventory->currentPage()]) }}"
                    class="btn btn-success">Export to Excel</a>
                <a href="{{ route('export-pdf-for-page', ['page' => $inventory->currentPage()]) }}"
                    class="btn btn-danger">Export to PDF</a>
            </div>
            {{-- Import Modal --}}
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form enctype="multipart/form-data" method="POST" action="{{ route('inventory.import') }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="file" id="importFileInput" name="file">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Import Modal --}}
        </div>
        <div class="row">
            @php
                $pdfExport = true;
            @endphp
            <div class="col-md-12 text-center">
                <div class="table-wrap" style="overflow-x: auto;">
                    <table id="inventory-table" class="table table-striped table-hover table-responsive display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Posisi</th>
                                <th>Merk</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                                <th>Print</th>
                                <th>Detail</th>
                                <th>Edit</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($inventory))
                                <tr>
                                    @forelse ($inventory as $key => $col)
                                        </td>
                                        <td>{{ $inventory->firstItem() + $key }}</td>
                                        <td>{{ $col->nama_barang }}</td>
                                        <td>{{ $col->posisi }}</td>
                                        <td>{{ $col->merk }}</td>
                                        <td>
                                            @if ($col->tanggal_masuk)
                                                {{ \Carbon\Carbon::parse($col->tanggal_masuk)->format('F j, Y') }}
                                            @else
                                                No Date Available
                                            @endif
                                        </td>
                                        <td>
                                            @if ($col->status === 'Barang Masuk')
                                                <a href="{{ url('/masuk') }}" class="btn btn-info"
                                                    style="background-color: blue; color: white;">
                                                    {{ $col->status }}
                                                </a>
                                            @elseif ($col->status === 'Barang Keluar')
                                                <a href="#" class="btn btn-info"
                                                    style="background-color: red; color: white;">
                                                    {{ $col->status }}
                                                </a>
                                            @else

                                            @endif
                                        </td>
                                        <td>
                                            <!-- Inside the button element -->
                                            <button type="button" class="btn"
                                                style="background-color: black; border: none; padding: 10px; outline: none;"
                                                data-barcode="{{ $col->barcode }}" data-nama="{{ $col->nama_barang }}"
                                                data-posisi="{{ $col->posisi }}" data-merk="{{ $col->merk }}"
                                                onclick="printQR(this)">
                                                <i class="bi bi-printer-fill"
                                                    style="color: rgb(255, 255, 255); font-size: 24px; line-height: 1;"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn"
                                                style="background-color: blue; border: none; padding: 10px; outline: none;"
                                                data-bs-toggle="modal" data-bs-target="#previewModal{{ $col->id }}">
                                                <i class="bi bi-info-circle"
                                                    style="color: rgb(255, 255, 255); font-size: 24px; line-height: 1;"></i>
                                            </button>
                                            @include('livewire.modal')
                                        </td>
                                        <td>
                                            <a href="{{ url('inventory/' . $col->id . '/edit') }}" class="btn"
                                                style="background-color: green; border: none; padding: 10px; outline: none;">
                                                <i class="fa fa-pencil"
                                                    style="color: rgb(255, 255, 255); font-size: 24px; line-height: 1;"></i>
                                                <!-- Edit Icon -->
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ url('inventory/' . $col->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-delete"
                                                    style="background-color: red; border: none; padding: 10px; outline: none;">
                                                    <i class="bi bi-trash"
                                                        style="color: rgb(255, 255, 255); font-size: 24px; line-height: 1;"></i>
                                                </button>
                                            </form>
                                        </td>
                                </tr>
                                <!-- Add other table rows here following the same structure -->
                            @empty
                                <tr>
                                    <td colspan="11">No Data Enough</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="11">
                                    <div class="d-flex justify-content-center mb-3 gap-2"
                                        style="visibility: hidden; padding: 0%;" id="action-buttons">
                                        <button style="margin-bottom: 10px" class="btn btn-primary delete_all"
                                            data-url="{{ url('myproductsDeleteAll') }}">Delete All Selected</button>
                                        {{-- @if (!$inventory->isEmpty())
                                            <form action="{{ route('ganti-ke-barang-keluar', $col->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">
                                                    Ganti Ke Barang Keluar
                                                </button>
                                            </form>
                                        @endif --}}
                                        <div id="selected-item-count"></div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $inventory->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    @livewireScripts

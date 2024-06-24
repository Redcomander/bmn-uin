@extends('layouts.dashboard-nav')

@section('content')
    <style>
        body {
            margin: 2em;
        }

        .btn-delete {
            background: none;
            border: none;
            padding: 0;
            outline: none;
            cursor: pointer;
            /* Add a pointer cursor for better UX */
        }

        .btn-delete i {
            color: red;
            font-size: 24px;
            line-height: 1;
            transition: color 0.3s;
            /* Add a color transition for a hover effect */
        }

        .btn-delete:hover i {
            color: darkred;
            /* Change the color on hover */
        }

        /* Style for the previewModal */
        .custom-modal {
            background: rgba(0, 0, 0, 0.8);
        }

        /* Style for the photo container */
        .photo-container {
            text-align: center;
            background: #f5f5f5;
            padding: 20px;
            border: 2px dashed #ccc;
        }

        /* Style for the "No Image" text */
        .no-image-text {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            /* Center the "No Image" text */
        }

        /* Style for the search bar container */
        .input-group {
            border: 2px solid #f2f2f2;
            /* Light gray outline for the search bar */
            border-radius: 5px;
            padding: 0px;
        }

        .search-label {
            border: none;
        }
    </style>

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section my-4">LIST BARANG</h2>
            </div>
            @if (auth()->check())
                @if (auth()->user()->hasPermission('read_write'))
                    <div class="d-flex justify-content-end mb-3 gap-2">
                        <a href="{{ url('inventory/create') }}" class="btn btn-dark d-none d-sm-inline">
                            <i class="bi bi-plus"></i> New
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                            Import
                        </button>
                        <a href="{{ route('export-inventory') }}" class="btn btn-success">Export to Excel</a>
                        {{-- <a href="{{ route('export-pdf-for-page', ['page' => $inventory->currentPage()]) }}"
                    class="btn btn-danger">Export to PDF</a> --}}
                    </div>
                @endif

                <div class="row justify-content-end mb-4">
                    <div class="col-lg-3">
                        <form method="GET" action="">
                            <div class="input-group">
                                <div class="form-outline">
                                    <input type="text" class="form-control search-label" name="search" />
                                    <label class="form-label" for="form1">Search</label>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="searchDropdown"
                                        data-bs-toggle="dropdown" style="padding: 13px" aria-haspopup="true"
                                        aria-expanded="false">
                                        Search In
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="searchDropdown">
                                        {{-- <button class="dropdown-item" type="submit" name="search_field"
                                            value="barcode">Barcode</button> --}}
                                        <button class="dropdown-item" type="submit" name="search_field"
                                            value="tahun_pengadaan">Tahun</button>
                                        <button class="dropdown-item" type="submit" name="search_field"
                                            value="nama_barang">Nama barang</button>
                                        <button class="dropdown-item" type="submit" name="search_field"
                                            value="tahun_pengadaan">Tahun</button>
                                        <button class="dropdown-item" type="submit" name="search_field"
                                            value="merk">Merk</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    <div class="row table-responsive mb-5">
        <table class="table table-striped text-center table-responsive" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Posisi</th>
                    <th>Merk</th>
                    <th>Tanggal Input</th>
                    <th>Status</th>
                    <th>Detail</th>
                    @if (auth()->user()->hasPermission('read_write'))
                        <th>Edit</th>
                        <th>Hapus</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php $counter = 1 @endphp
                @foreach ($inventory as $col)
                    <tr>
                        </td>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $col->nama_barang }}</td>
                        <td>{{ $col->jumlah }}</td>
                        <td>{{ $col->posisi }}</td>
                        <td>{{ $col->merk }}</td>
                        <td>
                            @if ($col->tanggal_input)
                                {{ \Carbon\Carbon::parse($col->tanggal_input)->format('F j, Y') }}
                            @else
                                No Date Available
                            @endif
                        </td>
                        <td>
                            @if ($col->status === 'Barang Masuk')
                                <a href="{{ url('/masuk') }}" class="btn btn-info"
                                    style="background-color: green; color: white;">
                                        {{ $col->status }}
                                </a>
                            @elseif ($col->status === 'Barang Keluar')
                                <a href="{{ url('/keluar') }}" class="btn btn-info" style="background-color: red; color: white;">
                                    {{ $col->status }}
                                </a>
                            @else
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn"
                                style="background-color: blue; border: none; padding: 10px; outline: none;"
                                data-bs-toggle="modal" data-bs-target="#previewModal{{ $col->id }}">
                                <i class="bi bi-info-circle"
                                    style="color: rgb(255, 255, 255); font-size: 24px; line-height: 1;"></i>
                            </button>
                            @include('list_barang.modal')
                        </td>
                        @if (auth()->user()->hasPermission('read_write'))
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
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $inventory->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif

@endsection

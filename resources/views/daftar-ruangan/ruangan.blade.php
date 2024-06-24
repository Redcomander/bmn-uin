@extends('layouts.dashboard-nav')

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <style>
        /* Separate list-group style */
        .custom-list-group {
            margin: 0;
            padding: 0;
        }

        .custom-list-item {
            list-style: none;
            display: flex;
            justify-content space-between;
            align-items: center;
            /* Vertically center items */
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .custom-list-item:hover {
            background-color: #f2f2f2;
            cursor: default;
        }

        .user-info {
            flex: 2;
        }

        .container {
            margin-top: 50px;
        }

        /* Style for the previewModal */
        .custom-modal {
            background: rgba(0, 0, 0, 0.8);
        }

        .myfont {
            font-family: 'Montserrat', sans-serif;
            font-size: 10px;
            color: #009f4a;
        }

        .fontku {

            font-family: 'Roboto', sans-serif;

        }

        .actions {
            display: flex;
            align-items: center;
            /* Vertically center items */
        }


        .btn-delete {
            background-color: #c82333;
        }

        .btn-edit {
            background-color: #198754;
        }

        .btn-new {
            background-color: #000000;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
            /* Increase the font size for better visibility on mobile */
            margin-right: 5px;
            /* Increase the right margin for spacing */
            height: auto;
            /* Adjust the height to auto for better mobile layout */
        }

        @media (max-width: 991.98px) {
            .btn-new {
                margin-bottom: 7px;
            }

        }

        .btn-new:hover {
            background-color: #ffffff;
            /* New button hover color */
        }

        .btn-new-role {
            background-color: #000000;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
            gap: 1;
            /* Increase the font size for better visibility on mobile */
            height: auto;
            /* Adjust the height to auto for better mobile layout */
        }

        .btn-new-role:hover {
            background-color: #ffffff;
            /* New Role button hover color */
        }

        .dark-mode h4 {
            color: #fff;
        }

        .dark-mode .user-role {
            color: #fff;
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-12 mx-auto">
                <div class="card border-0 dark-mode">
                    <div class="card-body">
                        <div class="d-flex text-center">
                            <h4 class="lead dark-mode fontku mb-3" style="color: #000000; font-size: 30px">
                                <b><strong>DAFTAR BARANG RUANGAN</strong></b>
                            </h4>
                        </div>
                        @if (auth()->check())
                            <form method="GET" action="{{ route('ruangan.index') }}">
                                <select class="form-select mb-4" name="filter" id="filter">
                                    <option value="">All Positions</option>
                                    @foreach ($filters as $f)
                                        <option value="{{ $f->posisi }}" {{ $f->posisi == $filter ? 'selected' : '' }}>
                                            {{ $f->posisi }}
                                        </option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary" type="submit">Terapkan</button>
                                @if (auth()->user()->hasPermission('read_write'))
                                    <a href="{{ route('download-pdf', ['filter' => $filter]) }}"
                                        class="btn btn-danger">Download
                                        PDF</a>
                                    <a href="{{ route('download-word', ['filter' => $filter]) }}"
                                        class="btn btn-primary">Download
                                        Word</a>
                                @endif
                            </form>

                            <div class="table-responsive dark-mode"> <!-- Make the table responsive -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Merk</th>
                                            <th>Tahun</th>
                                            <th>Status</th>
                                            <th>Tanggal Masuk</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventory as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->nama_barang }}</td>
                                                <td>{{ $item->jumlah }}</td>
                                                <td>{{ $item->merk }}</td>
                                                <td>{{ $item->tahun_pengadaan }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>{{ $item->tanggal_input }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $inventory->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

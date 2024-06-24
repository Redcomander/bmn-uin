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
    @if (auth()->check())
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section my-4">Berita Acara</h2>
                </div>
                @if (auth()->user()->hasPermission('read_write'))
                    <div class="d-flex justify-content-end mb-3 gap-2">
                        <a href="{{ url('berita_acara/create') }}" class="btn btn-dark d-none d-sm-inline">
                            <i class="bi bi-plus"></i> New
                        </a>
                    </div>
                @endif
                <div class="row justify-content-end">
                    <div class="col-lg-3">
                        <form action="{{ route('berita_acara.index') }}" method="GET">
                            <div class="input-group">
                                <div class="form-outline">
                                    <input type="search" id="form1" class="form-control" name="search" />
                                    <label class="form-label" for="form1">Search</label>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row table-responsive mb-5">
                <table class="table table-striped text-center table-responsive" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Berita Acara</th>
                            <th>Tanggal</th>
                            <th>File View</th>
                            @if (auth()->user()->hasPermission('read_write'))
                                <th>Edit</th>
                                <th>Hapus</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1 @endphp
                        @foreach ($acara as $col)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $col->berita_acara }}</td>
                                <td>{{ \Carbon\Carbon::parse($col->tanggal)->format('j F Y') }}</td>
                                <td>
                                    <a href="{{ asset('uploads/' . $col->file) }}" class="btn"
                                        style="background-color: rgb(17, 0, 128); border: none; padding: 10px; outline: none;"
                                        target="_blank">
                                        <i class="bi bi-filetype-pdf"
                                            style="color: rgb(255, 255, 255); font-size: 24px; line-height: 1;"></i>
                                    </a>
                                </td>
                                @if (auth()->user()->hasPermission('read_write'))
                                    <td>
                                        <a href="{{ url('berita_acara/' . $col->id . '/edit') }}" class="btn"
                                            style="background-color: green; border: none; padding: 10px; outline: none;">
                                            <i class="fa fa-pencil"
                                                style="color: rgb(255, 255, 255); font-size: 24px; line-height: 1;"></i>
                                            <!-- Edit Icon -->
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ url('berita_acara/' . $col->id) }}" method="post">
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
                {{ $acara->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
@endsection

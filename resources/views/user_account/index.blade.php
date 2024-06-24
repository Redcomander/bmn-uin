@extends('layouts.dashboard-nav')

@section('content')
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

        .user-name {
            font-weight: bold;
        }

        .user-role {
            font-size: 12px;
        }

        .container {
            margin-top: 150px;
        }

        .myfont {
            font-family: 'Montserrat', sans-serif;
            font-size: 10px;
            color: #009f4a;
        }

        .actions {
            display: flex;
            align-items: center;
            /* Vertically center items */
        }

        .btn {
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 0.8rem;
            /* Adjust font size to make it smaller */
            margin-right: 5px;
            /* Increase the right margin for spacing */
            height: auto;
            /* Adjust the height to auto for better mobile layout */
        }

        .btn-delete {
            background-color: #c82333;
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
            .btn-new-role {
                margin-bottom: 10px;
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
                        <div class="d-flex justify-content-between">
                            <h4 class="lead dark-mode" style="color: #198754;">
                                <b>MANAGEMENT USER ACCOUNT</b>
                            </h4>
                            <div class="justify-content-end mb-3">
                                <a href="{{ url('user/create') }}" class="btn btn-new d-none d-sm-inline">
                                    <i class="bi bi-plus"></i> New
                                </a>
                                <a href="{{ url('role/create') }}" class="btn btn-new-role d-none d-sm-inline">
                                    <i class="bi bi-plus"></i> New Role
                                </a>
                            </div>
                            <!-- Show buttons only on mobile view -->
                            <div class="d-sm-none">
                                <a href="{{ url('user/create') }}" class="btn btn-new">
                                    <i class="bi bi-plus"></i> New
                                </a>
                                <a href="{{ url('role/create') }}" class="btn btn-new-role">
                                    <i class="bi bi-plus"></i> New Role
                                </a>
                            </div>
                        </div>
                        {{-- Separate the list-group with custom styles --}}
                        <ul class="list-group custom-list-group dark-mode">
                            @forelse ($users as $col)
                                <li class="custom-list-item">
                                    <div class="user-info">
                                        <span class="user-name">{{ $col->name }}</span>
                                        <span class="user-role myfont dark-mode"
                                            style="background-color: #aeaeae; padding: 1%; border-radius: 5px;">
                                            @if ($col && $col->role)
                                                {{ $col->role->role }}
                                            @else
                                                No Role Assigned
                                            @endif
                                        </span>
                                        <br>
                                        {{ $col->username }}
                                    </div>
                                    <div class="actions">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ url('user/' . $col->id . '/edit') }}" class="btn btn-success">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ url('user/' . $col->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-delete">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

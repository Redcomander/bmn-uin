@extends('layouts.dashboard-nav')

@section('content')
    <style>
        body {
            margin: 2em;
        }
    </style>

    <div class="container">
        <h2 class="text-center fontku table-responsive">LIST BARANG KELUAR</h2>
        <table class="table table-striped text-center" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Posisi</th>
                    <th>Status</th>
                    <th>Jumlah</th>
                    <th>Tanggal Keluar</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1 @endphp
                @foreach ($inventory as $col)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $col->nama_barang }}</td>
                        <td>{{ $col->posisi }}</td>
                        <td>{{ $col->status }}</td>
                        <td>{{ $col->jumlah }}</td>
                        <td>{{ $col->tanggal_keluar }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $inventory->links('pagination::bootstrap-5') }}
    </div>

    {{-- <script>
        $(document).ready(function() {
            //Only needed for the filename of export files.
            //Normally set in the title tag of your page.
            document.title = "List Barang Keluar";
            // Create search inputs in footer
            $("#example tfoot th").each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });
            // DataTable initialisation
            var table = $("#example").DataTable({
                paging: true,
                autoWidth: true,
                buttons: [
                    "colvis",
                    "copyHtml5",
                    "csvHtml5",
                    "excelHtml5",
                    "pdfHtml5",
                    "print"
                ],
                initComplete: function(settings, json) {
                    var footer = $("#example tfoot tr");
                    $("#example thead").append(footer);
                }
            });

            // Apply the search
            $("#example thead").on("keyup", "input", function() {
                table.column($(this).parent().index())
                    .search(this.value)
                    .draw();
            });

            // Custom row filtering
            table.column(3).search('Barang Keluar').draw();
        });
    </script> --}}
@endsection

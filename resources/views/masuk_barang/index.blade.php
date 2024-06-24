@extends('layouts.dashboard-nav')

@section('content')
    <style>
        body {
            margin: 2em;
        }
    </style>

    <div class="container table-responsive">
        <h2 class="text-center myfont">LIST BARANG MASUK</h2>

        <table class="table table-striped table-responsive text-center"
            width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Posisi</th>
                    <th>Status</th>
                    <th>Jumlah</th>
                    <th>Tanggal Input</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1 @endphp
                @foreach ($inventory as $col)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $col->nama_barang }}</td>
                        <td>{{ $col->posisi }}</td>
                        <td>{{ $col->status }}</td>
                        <td>{{ $col->jumlah }}</td>
                        <td>{{ $col->tanggal_input }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $inventory->links('pagination::bootstrap-5') }}
    </div>


    {{-- <script>
        $(document).ready(function() {
            // Only needed for the filename of export files.
            // Normally set in the title tag of your page.
            document.title = "Barang Masuk";

            // Create search inputs in footer
            $("#example tfoot th").each(function() {
                var title = $(this).text();
                if (title !== "No") { // Check if the column title is not "No"
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                } else {
                    $(this).html(''); // Remove the input for the "No" column
                }
            });

            // DataTable initialization
            var table = $("#example").DataTable({
                paging: true,
                autoWidth: true,
                responsive: true,
                scrollX: true,

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
            table.column(3).search('Barang Masuk').draw(); // Adjusted column index
        });
    </script> --}}
@endsection

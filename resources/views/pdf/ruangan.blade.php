<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding: 8px;
        text-align: center;
    }

    td {
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
    }
</style>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Inventaris</th>
            <th>Inputter</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Tanggal Masuk</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php
            $counter = 1; // Initialize the counter
        @endphp
        @forelse ($inventory as $col)
            <tr>
                <td>{{ $counter++ }}</td>
                <td>
                    @if (str_word_count($col->no_inventaris) <= 20)
                        {{ $col->no_inventaris }}
                    @else
                        {{ str_word_count($col->no_inventaris, 2, '.', 2) }}
                    @endif
                </td>
                <td>{{ $col->inputter_name }}</td>
                <td>{{ $col->nama_barang }}</td>
                <td>{{ $col->merk }}</td>
                <td>
                    @if ($col->tanggal_masuk)
                        {{ \Carbon\Carbon::parse($col->tanggal_masuk)->format('F j, Y') }}
                    @else
                        No Date Available
                    @endif
                </td>
                <td>
                        {{ $col->status }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No Data Enough</td>
            </tr>
        @endforelse
    </tbody>
</table>

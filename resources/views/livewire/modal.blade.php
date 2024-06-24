<!-- Detail Modal -->
<div class="modal fade custom-modal" id="previewModal{{ $col->id }}" tabindex="-1"
    aria-labelledby="previewModalLabel{{ $col->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content custom-modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel{{ $col->id }}" style="color: #198754;">Detail Barang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 10px">
                <!-- Display the data here -->
                <div class="photo-container">
                    @if ($col->foto)
                        <img src="{{ asset('storage/' . $col->foto) }}" alt="foto" class="img-fluid">
                    @else
                        <p class="no-image-text">No Image</p>
                    @endif
                </div>
                <table class="table table-stripped">
                    <tr>
                        <th>Nama Barang</th>
                        <td>:</td>
                        <td>{{ $col->nama_barang }}</td>
                    </tr>
                    <tr>
                        <th>Inputter</th>
                        <td>:</td>
                        <td>{{ $col->inputter_name }}</td>
                    </tr>
                    <tr>
                        <th>Merk</th>
                        <td>:</td>
                        <td>{{ $col->merk }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>:</td>
                        <td>
                            @if ($col->tanggal_masuk)
                                {{ \Carbon\Carbon::parse($col->tanggal_masuk)->format('F j, Y') }}
                            @else
                                No Date Available
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tahun</th>
                        <td>:</td>
                        <td>{{ $col->tahun }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:</td>
                        <td>{{ $col->status }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Inventaris</th>
                        <td>:</td>
                        <td style="word-wrap:break-word;">{{ $col->no_inventaris }}</td>
                    </tr>
                    <tr>
                        <th>Posisi</th>
                        <td>:</td>
                        <td>{{ $col->posisi }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>:</td>
                        <td>{{ $col->Keterangan }}</td>
                    </tr>
                </table>
                @if (!empty($col->barcode))
                    <div class="text-center">
                        {!! QrCode::size(100)->generate($col->barcode) !!}
                    </div>
                @else
                    <div class="block-item">No Barcode Available</div>
                @endif
                <!-- You can add more details as needed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

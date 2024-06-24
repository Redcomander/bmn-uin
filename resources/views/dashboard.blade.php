@extends('layouts.dashboard-nav')

@section('content')
    <style>
        .jumbotron {
            margin: 0;
            padding: 0;
        }

        .jumbotron .container {
            padding-top: 60px;
            /* Adjust this value to move the content down */
            padding-bottom: 20px;
        }

        /* CSS for legend container */
        .legend-container {
            text-align: left;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f7f7f7;
        }

        /* CSS for legend items */
        .legend-color {
            width: 20px;
            height: 12px;
            display: inline-block;
            margin-right: 5px;
        }

        @media (max-width: 991.98px) {
            #update-card {
                margin-top: 10px;
            }
        }

        #log-list {
            border-radius: 0;
        }

        #log-list:hover {
            background-color: #666666
        }
    </style>

    {{-- Bar Chart and Donut Chart within a Card --}}
    <div class="row justify-content-evenly my-3 mb-3">
        @if (auth()->check())
            <div class="col-12 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center">Grafik Barang BMN</h4>
                        <div class="mt-3 text-center">
                            <canvas id="barChart" width="100" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body justify-content-center">
                        <h4 class="text-center">Grafik Keseluruhan Barang</h4>
                        <div class="mt-3 text-center mb-5">
                            <canvas id="donutChart" width="100" height="45"></canvas>
                        </div>
                        <div class="mb-4 text-center">
                            @if (auth()->user()->hasPermission('read_write'))
                                <form method="POST" action="{{ route('aggregate-data') }}">
                                    @csrf
                                    <button class="btn btn-info" type="submit">Aggregate Data</button>
                                </form>
                            @endif
                        </div>
                        <table id="myTable" class="table table-responsive table-stripped">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th></th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategori as $col)
                                    <tr>
                                        <td>{{ $col->kategori }}</td>
                                        <td>:</td>
                                        <td>{{ $col->jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if (auth()->user()->hasPermission('read_write'))
                <div class="col-12 col-lg-4 text-center vh-100">
                    <div id="update-card" class="card">
                        <div class="card-body">
                            <h4>Update Terbaru</h4>
                            <ul class="list-group">
                                @foreach ($recentActivities as $activity)
                                    <li id="log-list" class="list-group-item fontku">
                                        <span>{{ $activity->user->name }} performed {{ $activity->operation }} on
                                            {{ $activity->model }}</span>
                                        @if (!empty($activity->changes))
                                            <span class="text-success">with changes: {{ $activity->changes }}</span>
                                        @endif
                                        <span class="text-muted">at {{ $activity->created_at }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-3">
                                {{ $recentActivities->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
    {{-- Bar Chart and Donut Chart within a Card --}}

    <!-- Tambahkan script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                dom: 'B<"clear">lfrtip',
                buttons: ['copy', 'csv', 'excel']
            });
        });
    </script>
    <script>
        // Data contoh untuk donut chart
        let barang = {{ Js::from($data2) }};
        let labelBarang = Object.keys(barang);
        let dataBarang = Object.values(barang);

        function sumJumlahForKategori(labelBarang, dataBarang) {
            const aggregatedData = {};
            for (let i = 0; i < labelBarang.length; i++) {
                const label = labelBarang[i];
                const jumlah = parseFloat(dataBarang[i]);

                if (!aggregatedData[label]) {
                    aggregatedData[label] = 0;
                }
                aggregatedData[label] += jumlah;
            }
            return {
                labels: Object.keys(aggregatedData),
                data: Object.values(aggregatedData),
            };
        }

        const {
            labels,
            data
        } = sumJumlahForKategori(labelBarang, dataBarang);

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        const uniqueColors = {};
        const backgroundColors = labels.map((label) => {
            if (!uniqueColors[label]) {
                uniqueColors[label] = getRandomColor();
            }
            return uniqueColors[label];
        });

        var chartData = {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: backgroundColors,
            }]
        };

        // Inisialisasi dan konfigurasi donut chart
        var ctx = document.getElementById("donutChart").getContext("2d");
        var doughnutChart = new Chart(ctx, {
            type: "doughnut",
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                        position: 'right',
                    },
                    title: {
                        display: false,
                        text: 'Jumlah Seluruh Barang'
                    }
                }
            },
        });
    </script>




    {{-- Bar Chart --}}
    <!-- Initialize and configure the bar chart with data labels -->
    <script>
        let inventaris = {{ Js::from($tahun) }};
        let labelTahun = Object.keys(inventaris);
        let dataBarangMasuk = [];
        let dataBarangKeluar = [];

        // Loop through each year and get the counts
        labelTahun.forEach(year => {
            // Check if the year exists in the inventaris object
            if (inventaris[year]) {
                // Get the counts for "barang_masuk" and "barang_keluar"
                let barangMasukCount = inventaris[year]['Barang Masuk'] || 0;
                let barangKeluarCount = inventaris[year]['Barang Keluar'] || 0;

                // Push the counts to the respective arrays
                dataBarangMasuk.push(barangMasukCount);
                dataBarangKeluar.push(barangKeluarCount);
            } else {
                // If the year is not in the inventaris object, push 0
                dataBarangMasuk.push(0);
                dataBarangKeluar.push(0);
                labelTahun.push("No Data"); // Add "No Data" label for missing data
            }
        });

        // Data for bar chart representing years
        var barData = {
            labels: labelTahun, // Use the modified 'labelTahun' array for the labels
            datasets: [{
                    label: "Barang Masuk",
                    data: dataBarangMasuk, // Use 'dataBarangMasuk' for the data
                    backgroundColor: 'rgba(0, 216, 2, 0.8)' // Green
                },
                {
                    label: "Barang Keluar",
                    data: dataBarangKeluar, // Use 'dataBarangKeluar' for the data
                    backgroundColor: 'rgba(255, 0, 0, 0.8)' // Red
                }
            ]
        };

        // ...


        // Initialize and configure the bar chart with data labels
        var barCtx = document.getElementById("barChart").getContext("2d");
        var barChart = new Chart(barCtx, {
            type: "bar",
            data: barData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Tahun'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        display: true,
                        title: {
                            display: true,
                            text: 'Jumlah Data'
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        anchor: 'end', // Adjust the position of the data labels
                        align: 'end', // Adjust the alignment of the data labels
                        color: 'black', // Color of the data labels
                        font: {
                            weight: 'bold' // Font weight of the data labels
                        },
                        formatter: function(value, context) {
                            return value; // Display the actual data value
                        }
                    }
                }
            }
        });
    </script>
@endsection

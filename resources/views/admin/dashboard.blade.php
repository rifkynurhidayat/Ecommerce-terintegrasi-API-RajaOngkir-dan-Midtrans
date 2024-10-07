@extends('admin.layouts.home')
@section('title', 'dashboard')
@section('content')
    <div class="container-fluid">

        @php
            $ekspedisiRoleId = 3;
        @endphp

        @if (Auth::user()->role_id != $ekspedisiRoleId)
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            <!-- Content Row -->
            <div class="row">

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Pelanggan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pelanggan }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-2x fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Order</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $order }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Produk
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $produk }}
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total keuntungan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.{{ number_format($keuntungan) }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="p-4 bg-light shadow col-md-12 mb-4 ">
                    <h5 class="mb-3 text-center">Keterangan :</h5>
                    <p>R(12-19) L = Remaja Laki laki dengan umur 12-19 tahun</p>
                    <p>D(20-40) L = Dewasa Laki laki dengan umur 20-40 tahun</p>
                    <p>R(12-19) P = Remaja Perempuan dengan umur 12-19 tahun</p>
                    <p>D(20-40) P = Dewasa Perempuan dengan umur 20-40 tahun</p>
                    <p>OT(41-100) L = Orang Tua Laki laki dengan umur 41-100 tahun</p>
                    <p>OT(41-100) P = Orang Tua Perempuan dengan umur 41-100 tahun</p>
                </div>
            </div>

            <!-- Content Row -->

            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h6 class="my-auto font-weight-bold text-primary">Grafik Produk Unggulan</h6>
                            <form action="/" class="form-inline">
                                <div class="form-group mr-3">
                                    <label for="start_date">Pilih Tanggal Mulai:</label>
                                    <input type="date" class="form-control datetimepicker-input" name="start_date"
                                        value="{{ request('start_date') }}" />
                                </div>
                                <div class="form-group mr-3">
                                    <label for="end_date">Pilih Tanggal Akhir:</label>
                                    <input type="date" class="form-control datetimepicker-input" name="end_date"
                                        value="{{ request('end_date') }}" />
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Filter</button>

                            </form>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <div id="chartUnggulan"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
            </div>
            <div class="row">

                <!-- Area Chart -->
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Pembelian</h6>
                            <form action="" class="form-inline">
                                <div class="form-group mr-3">
                                    <label for="mulai">Pilih Tanggal Mulai:</label>
                                    <input type="date" class="form-control datetimepicker-input" name="mulai"
                                        value="{{ request('mulai') }}" />
                                </div>
                                <div class="form-group mr-3">
                                    <label for="akhir">Pilih Tanggal Akhir:</label>
                                    <input type="date" class="form-control datetimepicker-input" name="akhir"
                                        value="{{ request('akhir') }}" />
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Filter</button>

                            </form>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <div id="chartPreferensiPembelian"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-7">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Grafik Keuntungan Penjualan</h6>
                            <form action="" class="form-inline">
                                <div class="form-group mr-3">
                                    <label for="mulaiKeuntungan">Pilih Tanggal Mulai:</label>
                                    <input type="date" class="form-control datetimepicker-input"
                                        name="mulaiKeuntungan" value="{{ request('mulaiKeuntungan') }}" />
                                </div>
                                <div class="form-group mr-3">
                                    <label for="akhirKeuntungan">Pilih Tanggal Akhir:</label>
                                    <input type="date" class="form-control datetimepicker-input"
                                        name="akhirKeuntungan" value="{{ request('akhirKeuntungan') }}" />
                                </div>
                                <button type="submit" class="btn btn-primary mb-2">Filter</button>
                            </form>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <div id="chartKeuntungan"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-5">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Sebaran Demografi</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <div id="chartDemografi"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-5">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Kategori Produk</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-area">
                                <div id="chartCategory"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var options = {
            series: {!! $series !!},
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: {!! $categories !!},
            },
            yaxis: {
                title: {
                    text: 'Total Quantity'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " qty";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartUnggulan"), options);
        chart.render();
    </script>

    <script>
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: @json($seri),
            xaxis: {
                categories: @json($kategori), // Menampilkan kategori produk di sumbu X
            },
            yaxis: {
                title: {
                    text: 'Jumlah Transaksi'
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false // Menonaktifkan label persentase
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chartPreferensiPembelian"), options);
        chart.render();
    </script>

    <script>
        var options = {
            series: Array(@json($pieCategory).length).fill(1),
            chart: {
                width: 500,
                type: 'pie',
            },
            labels: @json($pieCategory),
            dataLabels: {
                enabled: false // Menonaktifkan persentase
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chartCategory"), options);
        chart.render();
    </script>

<script>
    var options = {
        series: [{
            name: 'Laki-laki',
            data: @json($dataLakilaki)
        }, {
            name: 'Perempuan',
            data: @json($dataPerempuan)
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: @json($labels), // Nama-nama kota
        },
        legend: {
            position: 'top'
        },
        fill: {
            opacity: 1
        }
    };

    var chart = new ApexCharts(document.querySelector("#chartDemografi"), options);
    chart.render();
</script>


    <script>
        var options = {
            series: [{
                name: 'Total Keuntungan',
                data: @json($dataKeuntungan)
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: 'Keuntungan Per Bulan',
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: @json($bulanArray),
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return value.toLocaleString("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        });
                    }
                }
            },
        };

        var chart = new ApexCharts(document.querySelector("#chartKeuntungan"), options);
        chart.render();
    </script>
@endsection

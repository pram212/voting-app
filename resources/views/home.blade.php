@extends('layouts.main')

@section('header-content', 'DASHBOARD')
@section('title', 'DASHBOARD')

@section('content')
    <!-- Content Row -->
    <div class="row">
        {{-- FILTER --}}
        @if (auth()->user()->role == 1)
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="province_id">Provinsi</label>
                                        <select class="form-control select2" name="province_id" id="select-provinsi">
                                            @if (request('province_name'))
                                                <option value="{{ request('province_id') }}" selected>
                                                    {{ request('province_name') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="regency_id">Kota</label>
                                        <select class="form-control select2" name="regency_id" id="select-kota">
                                            @if (request('regency_name'))
                                                <option value="{{ request('regency_id') }}" selected>
                                                    {{ request('regency_name') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="district_id">Kecamatan</label>
                                        <select class="form-control select2" name="district_id" id="select-kecamatan">
                                            @if (request('district_name'))
                                                <option value="{{ request('district_id') }}" selected>
                                                    {{ request('district_name') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="village_id">Desa</label>
                                        <select class="form-control select2" name="village_id" id="select-desa">
                                            @if (request('village_name'))
                                                <option value="{{ request('village_id') }}" selected>
                                                    {{ request('village_name') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-primary">Filter</button>
                                    <a href="{{ url('home') }}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        Statistik Rekapan TPS Provinsi
                        <strong>{{ ucwords(strtolower(auth()->user()->provinsi->name)) }}</strong>,
                        Kota/Kabupaten
                        <strong>{{ ucwords(strtolower(str_replace('KABUPATEN', '', auth()->user()->kota->name))) }}</strong>,
                        Kecamatan <strong>{{ ucwords(strtolower(auth()->user()->kecamatan->name)) }}</strong>,
                        Desa/Kelurahan <strong>{{ ucwords(strtolower(auth()->user()->desa->name)) }}</strong>,
                    </div>
                </div>
            </div>
        @endif
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah TPS</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalTps) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-university fa-2x text-gray-300"></i>
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
                                Total Suara</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalSuara, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Progress Bar</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    @foreach (@$progressBarData as $item)
                        <h4 class="small font-weight-bold">{{ @$item['calon'] }} <span
                                class="float-right">{{ @$item['persentase'] }}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar"
                                style="width: {{ $item['persentase'] }}%; background-color: {{ $item['color'] }}"
                                aria-valuenow="{{ $item['persentase'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Lingkaran</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>


    <script>
        var pieLabels = @json($pieChartLabels);
        var pieDatas = @json($pieChartData);
        var pieColor = @json($pieChartColor);
        console.log(pieDatas);
        // PIE CHART
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito',
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        // Pie Chart Example
        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieDatas,
                    backgroundColor: pieColor,
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true
                },
                cutoutPercentage: 80,
            },
        });

    </script>
    <script src="{{ asset('js/filter_location.js') }}"></script>
@endsection

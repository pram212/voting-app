@extends('layouts.main')

@section('header-content', 'REKAPAN SAKSI')
@section('title', 'Rekapan Saksi')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
        </div>
        <div class="card-body">
            <form action="" id="form-filter">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control select2" name="province_id" id="select-provinsi">
                                @if (request('province_name'))
                                    <option value="{{ request('province_id') }}" selected>{{ request('province_name') }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="regency_id">Kota</label>
                            <select class="form-control select2" name="regency_id" id="select-kota">
                                @if (request('regency_name'))
                                    <option value="{{ request('regency_id') }}" selected>{{ request('regency_name') }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="district_id">Kecamatan</label>
                            <select class="form-control select2" name="district_id" id="select-kecamatan">
                                @if (request('district_name'))
                                    <option value="{{ request('district_id') }}" selected>{{ request('district_name') }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit">Tampilkan</button>
                        <a href="{{ url('rekapan/saksi') }}" class="btn btn-danger" type="button">Reset</a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <div>
                    REKAPAN PER {{ $jenisrekap  }}
                </div>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="display responsive nowrap" width="100%" id="table-saksi">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="text-center">NO</th>
                            <th class="text-center">
                                {{ $jenisrekap  }}
                            </th>
                            <th>Jumlah Saksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekapitulasi as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->saksi_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right font-weight-bold">TOTAL PER {{$jenisrekap}}</td>
                            <td class="font-weight-bold">: {{ $totalSaksiPerLokasi }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right font-weight-bold">TOTAL KESELURUHAN</td>
                            <td class="font-weight-bold">: {{ $totalSaksi }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    <script>
        $('#table-saksi').DataTable({
            responsive: true,
            paging: false
        })
    </script>

    <!-- Filter Location -->
    <script>
        // // select 2 event
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $('#select-provinsi').select2({
            ajax: {
                url: '/select2/getprovinsi',
                dataType: 'json'
            },
            allowClear: true,
            placeholder: '-- Pilih --',
        });

        var provinsi = $("#select-provinsi").val();
        var kota = $("#select-kota").val();
        var kecamatan = $("#select-kecamatan").val();

        $('#select-kota').select2({
            ajax: {
                url: '/select2/getkota?province_id=' + provinsi,
                dataType: 'json'
            },
            allowClear: true,
            placeholder: '-- Pilih --',
        });

        $('#select-kecamatan').select2({
            ajax: {
                url: '/select2/getkecamatan?regency_id=' + kota,
                dataType: 'json'
            },
            allowClear: true,
            placeholder: '-- Pilih --',
        });

        $('#select-desa').select2({
            ajax: {
                url: '/select2/getdesa?district_id=' + kecamatan,
                dataType: 'json'
            },
            allowClear: true,
            placeholder: '-- Pilih --',
        });

        $('#select-provinsi').on('select2:select', function(e) {
            $("#select-kota").select2('destroy');
            var data = e.params.data;
            $('#select-kota').select2({
                ajax: {
                    url: '/select2/getkota?province_id=' + data.id,
                    dataType: 'json'
                },
                allowClear: true,
                placeholder: '-- Pilih --',
            });
        });

        $('#select-kota').on('select2:select', function(e) {
            $("#select-kecamatan").select2('destroy');
            var data = e.params.data;
            $('#select-kecamatan').select2({
                ajax: {
                    url: '/select2/getkecamatan?regency_id=' + data.id,
                    dataType: 'json'
                },
                allowClear: true,
                placeholder: '-- Pilih --',
            });
        });

        $('#select-kecamatan').on('select2:select', function(e) {
            $("#select-desa").select2('destroy');
            var data = e.params.data;
            $('#select-desa').select2({
                ajax: {
                    url: '/select2/getdesa?district_id=' + data.id,
                    dataType: 'json'
                },
                allowClear: true,
                placeholder: '-- Pilih --',
            });
        });
    </script>
@endsection

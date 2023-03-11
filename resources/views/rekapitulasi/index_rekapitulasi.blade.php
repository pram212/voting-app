@extends('layouts.main')

@section('header-content', 'Hasil Rekapan TPS')
@section('title', 'Rekapitulasi')

@section('content')
    {{-- FILTER PANEL --}}
    @if (auth()->user()->role == 1)
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
            </div>
            <div class="card-body">
                <form action="" id="form-filter">
                    <div class="row">
                        <div class="col-md-3">
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

                        <div class="col-md-3">
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

                        <div class="col-md-3">
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

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="village_id">Desa</label>
                                <select class="form-control select2" name="village_id" id="select-desa">
                                    @if (request('village_name'))
                                        <option value="{{ request('village_id') }}" selected>{{ request('village_name') }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">Tampilkan</button>
                            <a href="{{ url('rekapitulasi') }}" class="btn btn-danger" type="button">Reset</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                @if (auth()->user()->role == 2)
                    <div class="text-xs">PROVINSI {{ auth()->user()->provinsi->name }}</div>
                    <div class="text-xs">{{ auth()->user()->kota->name }}</div>
                    <div class="text-xs">KECAMATAN {{ auth()->user()->kecamatan->name }}</div>
                    <div class="text-xs">DESA {{ auth()->user()->desa->name }}</div>
                @endif
            </h6>
        </div>
        <div class="card-body">
            <form action="">
                <div class="d-flex justify-content-between my-1">
                    <input name="nomor" type="text" class="form-control mx-1" placeholder="Cari..."
                        value="{{ @request('nomor') }}">
                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-sm table-bordered" cellspacing="0" id="dataTable">
                    <thead class="bg-dark text-white text-center">
                        <tr>
                            <th class="align-middle">TPS</th>
                            @foreach ($headerCalon as $item)
                                <th class="align-middle" colspan="2">NO. URUT {{ $item }}</th>
                            @endforeach
                            <th class="align-middle">CATATAN</th>
                            <th class="align-middle">USER</th>
                            <th class="align-middle">OPSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($rekapitulasi as $item)
                            <tr>
                                <td>{{ $item->nomor }}</td>
                                @foreach ($item->calon as $calon)
                                    <td>{{ $calon->keterangan }}</td>
                                    <td class="font-weight-bold">{{ $calon->pivot->jumlah_suara }}</td>
                                @endforeach
                                <td>{{ $item->catatan }}</td>
                                <td>{{ @$item->userEntry->name }}</td>
                                <th>
                                    <a href="{{ url('rekapitulasi/' . $item->id . '/edit') }}"
                                        class="btn btn-sm btn-success">
                                        @can('update', $item)
                                            Lihat
                                        @else
                                            Entry
                                        @endcan
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $rekapitulasi->onEachSide(5)->links() }}
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
    <script src="{{ asset('js/filter_location.js') }}"></script>
@endsection

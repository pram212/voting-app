@extends('layouts.main')

@section('header-content', 'Input Hasil ' . $tps->nomor)
@section('title', 'Rekapitulasi')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header text-primary font-weight-bold">
            <div class="text-xs">PROVINSI {{@$tps->provinsi->name}}</div>
            <div class="text-xs">{{@$tps->kota->name}}</div>
            <div class="text-xs">KECAMATAN {{@$tps->kecamatan->name}}</div>
            <div class="text-xs">DESA {{@$tps->desa->name}}</div>
        </div>
        <div class="card-body">
            <form action="{{ url('rekapitulasi/' . @$tps->id) }}" method="POST">
                @csrf
                @method('put')

                <div class="row">
                    @foreach (@$tps->calon as $item)
                    <input type="hidden" name="calon_id[]" value="{{$item->id}}">
                    <div class="col-md-12 text-success">
                        No. {{$item->no_urut}} - {{$item->keterangan }}
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah_suara">Jumlah Suara :</label>
                            <input type="number" class="form-control form-control-sm" name="jumlah_suara[]" value="{{ @$item->pivot->jumlah_suara}}"/>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="catatan">Catatan :</label>
                            <textarea class="form-control" name="catatan" id="catatan" cols="30" rows="3">{{@$tps->catatan}}</textarea>
                        </div>
                    </div>
                </div>
                
                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('rekapitulasi') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            // setup select option ajax
            $('#select-calon').select2({
                ajax: {
                    url: '/select2/getcalon',
                    dataType: 'json'
                }
            });

            $('#select-provinsi').select2({
                ajax: {
                    url: '/select2/getprovinsi',
                    dataType: 'json'
                }
            });

            $('#select-kota').select2({
                ajax: {
                    url: '/select2/getkota',
                    dataType: 'json'
                }
            });

            $('#select-kecamatan').select2({
                ajax: {
                    url: '/select2/getkecamatan',
                    dataType: 'json'
                }
            });

            $('#select-desa').select2({
                ajax: {
                    url: '/select2/getdesa',
                    dataType: 'json'
                }
            });

            $("#select-provinsi").change(function(e) {
                e.preventDefault();
                $('#select-kota').select2({
                    ajax: {
                        url: '/select2/getkota?province_id=' + e.target.value,
                        dataType: 'json'
                    }
                });
            });

            $("#select-kota").change(function(e) {
                e.preventDefault();
                $('#select-kecamatan').select2({
                    ajax: {
                        url: '/select2/getkecamatan?regency_id=' + e.target.value,
                        dataType: 'json'
                    }
                });
            });

            $("#select-kecamatan").change(function(e) {
                e.preventDefault();
                $('#select-desa').select2({
                    ajax: {
                        url: '/select2/getdesa?district_id=' + e.target.value,
                        dataType: 'json'
                    }
                });
            });

        });
    </script>
@endsection

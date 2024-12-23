@extends('layouts.main')

@section('header-content', 'Entry ' . $tps->nomor)
@section('title', 'Rekapitulasi')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header text-primary font-weight-bold">
            <div class="text-xs">PROVINSI {{@$tps->provinsi->name}}</div>
            <div class="text-xs">{{@$tps->kota->name}}</div>
            <div class="text-xs">KECAMATAN {{@$tps->kecamatan->name}}</div>
            <div class="text-xs">DESA{{@$tps->desa->name}}</div>
        </div>
        <div class="card-body">
            @error('max_jumlah_suara')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Gagal! </strong> {{$message}} periksa kembali data inputan Anda
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @enderror
            <form action="{{ url('rekapitulasi/' . @$tps->id) }}" method="POST" class=" needs-validation">
                @csrf
                @method('put')
                @php
                    $editable = auth()->user()->role == 2 ? true : false;
                @endphp

                <div class="row">
                    @foreach (@$tps->calon as $key => $item)
                    <input type="hidden" name="calon_id[]" value="{{$item->id}}">
                    <div class="col-md-6 border-bottom mb-2">
                        <span class="text-primary font-weight-bold">
                            No. {{$item->no_urut}} - {{$item->keterangan }}
                        </span>
                        <div class="form-group">
                            <label for="jumlah_suara">Jumlah Suara : {{$item->pivot->id}}</label>
                            <input @if(!$editable) disabled @endif type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==4) return false;" class="form-control form-control-sm" name="jumlah_suara[]" value="{{ old('jumlah_suara')[$key] ??@$item->pivot->jumlah_suara}}"/>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="catatan">Catatan :</label>
                            <textarea @if(!$editable) disabled @endif class="form-control" name="catatan" id="catatan" cols="30" rows="3">{{@$tps->catatan}}</textarea>
                        </div>
                    </div>
                    @if (!$editable)
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="catatan">User Entry :</label>
                            <input type="text" class="form-control" disabled value="{{ @$tps->userEntry->name }}">
                        </div>
                    </div>
                    @endif
                </div>
                
                <hr class="divider">

                <div class="text-center">
                    @can('create', App\Models\Rekapitulasi::class)
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    @endcan
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

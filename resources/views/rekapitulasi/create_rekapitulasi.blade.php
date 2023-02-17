@extends('layouts.main')

@section('header-content', 'Input Hasil')
@section('title', 'Rekapitulasi')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ url('rekapitulasi/' . @$tps->id) }}" method="POST">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="keterangan">Nama TPS</label>
                            <input type="text" class="form-control form-control-sm" name="keterangan" disabled value="{{ @$tps->keterangan }}"/>
                            @error('rt')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rt">RT</label>
                            <input type="text" class="form-control form-control-sm" name="rt" disabled  value="{{ @$tps->rt }}"/>
                            @error('rt')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rw">RW</label>
                            <input type="text" class="form-control form-control-sm" name="rw" disabled value="{{ @$tps->rw }}"/>
                            @error('rw')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <div class="row">
                    @foreach (@$tps->calon as $item)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" name="calon_id[]" value="{{$item->id}}">
                                    <label for="calon_id">No. Urut</label>
                                    <input type="number" class="form-control form-control-sm" readonly value="{{ @$item->no_urut}}"/>
                                </div>
                                <div class="form-group">
                                    <label for="calon_id">Calon</label>
                                    <input type="text" class="form-control form-control-sm" readonly value="{{ @$item->keterangan}}"/>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_suara">Jumlah Suara</label>
                                    <input type="number" class="form-control form-control-sm" name="jumlah_suara[]" value="{{ @$item->pivot->jumlah_suara}}"/>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Catatan</label>
                                    <textarea name="keterangan[]" id="keterangan" class="form-control form-control-sm" cols="30" rows="3">{{ @$item->pivot->keterangan}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                
                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('rekapitulasi') }}" class="btn btn-secondary">Batal</a>
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

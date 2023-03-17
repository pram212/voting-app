@extends('layouts.main')

@section('header-content', 'Register Desa')
@section('title', 'kecamatan')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @php
                $url = @$desa ? 'desa/' . $desa->id : 'desa'; 
            @endphp
            <form action="{{ url($url) }}" method="POST">
                @csrf

                @if (@$desa)
                    @method('PUT')
                @endif
                <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control" name="province_id" id="select-provinsi">
                                @if (@$desa)
                                <option value="{{@$desa->district->regency->province->id}}" selected>{{@$desa->district->regency->province->name}}</option>
                                @endif
                            </select>
                            @error('province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="regency_id">Kota</label>
                            <select class="form-control" required name="regency_id" id="select-kota">
                                @if (@$desa)
                                <option value="{{@$desa->district->regency->id}}" selected>{{@$desa->district->regency->name}}</option>
                                @endif
                            </select>
                            @error('regency_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="district_id">Kecamatan</label>
                            <select class="form-control" required name="district_id" id="select-kecamatan">
                                @if (@$desa)
                                <option value="{{@$desa->district->id}}" selected>{{@$desa->district->name}}</option>
                                @endif
                            </select>
                            @error('district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nama">Nama Desa :</label>
                            <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
                            id="name" placeholder="" value="{{old('name', @$desa->name)}}">
                            @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>

                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('desa') }}" class="btn btn-secondary">Kembali</a>
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
            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            $('#select-provinsi').select2({
                ajax: {
                    url: '/select2/getprovinsi',
                    dataType: 'json'
                }
            });

            $('#select-kota').select2();
            $('#select-kecamatan').select2();

            $('#select-provinsi').on('select2:select', function (e) {
                $("#select-kota").select2('destroy'); 
                var data = e.params.data;
                $('#select-kota').select2({
                    ajax: {
                        url: '/select2/getkota?province_id=' + data.id,
                        dataType: 'json'
                    }
                });
            });

            $('#select-kota').on('select2:select', function (e) {
                $("#select-kecamatan").select2('destroy'); 
                var data = e.params.data;
                $('#select-kecamatan').select2({
                    ajax: {
                        url: '/select2/getkecamatan?regency_id=' + data.id,
                        dataType: 'json'
                    }
                });
            });

        });
    </script>
@endsection

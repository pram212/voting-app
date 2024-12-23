@extends('layouts.main')

@section('header-content', 'Register Kecamatan')
@section('title', 'kecamatan')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @php
                $url = @$kecamatan ? 'pengaturan/kecamatan/' . $kecamatan->id : 'pengaturan/kecamatan'; 
            @endphp
            <form action="{{ url($url) }}" method="POST">
                @csrf

                @if (@$kecamatan)
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control" name="province_id" id="select-provinsi">
                                @if (@$kecamatan)
                                <option value="{{@$kecamatan->regency->province->id}}" selected>{{@$kecamatan->regency->province->name}}</option>
                                @endif
                            </select>
                            @error('province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regency_id">Kota</label>
                            <select class="form-control" required name="regency_id" id="select-kota">
                                @if (@$kecamatan)
                                <option value="{{@$kecamatan->regency->id}}" selected>{{@$kecamatan->regency->name}}</option>
                                @endif
                            </select>
                            @error('regency_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nama">Nama Kecamatan:</label>
                            <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
                            id="name" placeholder="" value="{{old('name', @$kecamatan->name)}}">
                            @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('pengaturan/kecamatan') }}" class="btn btn-secondary">Kembali</a>
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

        });
    </script>
@endsection

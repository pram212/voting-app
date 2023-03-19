@extends('layouts.main')

@section('header-content', 'Register Kota')
@section('title', 'Pengaturan Kota')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @php
                $url = @$kota ? 'pengaturan/kota/' . $kota->id : 'pengaturan/kota'; 
            @endphp
            <form action="{{ url($url) }}" method="POST">
                @csrf

                @if (@$kota)
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control" required name="province_id" id="select-provinsi">
                                @if (@$kota)
                                <option value="{{@$kota->province->id}}" selected>{{@$kota->province->name}}</option>
                                @endif
                            </select>
                            @error('province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Kota :</label>
                            <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror"
                            id="name" placeholder="" value="{{old('name', @$kota->name)}}">
                            @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('pengaturan/kota') }}" class="btn btn-secondary">Kembali</a>
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

        });
    </script>
@endsection

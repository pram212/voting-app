@extends('layouts.main')

@section('header-content', 'Register Administrator')
@section('title', 'Data Admin')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ url('pengaturan/user') }}" method="POST">
                @csrf
                <div class="row">
                    <p class="col-md-12 text-center">
                        BIODATA
                    </p>
                    <div class="form-group col-md-6">
                        <label for="name">Nama Lengkap :</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="validateName"
                            placeholder="" value="{{old('name')}}">
                        @error('name')
                        <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">No. Whatsapp :</label>
                        <input type="number" name="phone" min="10" class="form-control @error('phone') is-invalid @enderror" id="phone" aria-describedby="validateName"
                            placeholder="" value="{{old('phone')}}">
                        @error('phone')
                        <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Password :</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                        <small  class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <hr class="divider">
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                    <a href="{{ url('pengaturan/user') }}" class="btn btn-secondary">Kembali</a>
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

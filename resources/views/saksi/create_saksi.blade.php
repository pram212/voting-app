@extends('layouts.main')

@section('header-content', 'Register Pengguna')
@section('title', 'Pengguna')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ url('/user') }}" method="POST">
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
                        <label for="exampleInputEmail1">Email :</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Enter email" value="{{old('email')}}">
                        @error('email')
                        <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Password :</label>
                        <input type="password" name="password" readonly placeholder="default : password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                        <small  class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Role :</label>
                        <select class="custom-select @error('role') is-invalid @enderror" name="role">
                            <option value="2" @if (old('role') == 2)
                                selected
                            @endif>Saksi</option>
                            <option value="1" @if (old('role') == 1)
                            selected
                        @endif>Admin</option>
                        </select>
                        @error('role')
                        <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <hr class="divider">
                <div class="row">
                    <p class="col-md-12 text-center">
                        LOKASI
                    </p>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control " name="province_id" id="select-provinsi">
                            </select>
                            @error('province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regency_id">Kota</label>
                            <select class="form-control " name="regency_id" id="select-kota">
                            </select>
                            @error('regency_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="district_id">Kecamatan</label>
                            <select class="form-control " name="district_id" id="select-kecamatan">
                            </select>
                            @error('district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="village_id">Desa</label>
                            <select class="form-control " name="village_id" id="select-desa">
                            </select>
                            @error('village_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="divider">
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                    <a href="{{ url('/user') }}" class="btn btn-secondary">Kembali</a>
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
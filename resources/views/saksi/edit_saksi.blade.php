@extends('layouts.main')

@section('header-content', 'Profil Saksi')
@section('title', 'Pengaturan Saksi')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @php
                $editable = false;
            @endphp
            @if ($editable)
                
            <form action="{{ url('pengaturan/saksi/' . $user->id) }}" method="POST">
                @csrf
                @method('put')
            @endif
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-primary text-center font-weight-bold">BIODATA</p>
                    </div>
            
                    <div class="form-group col-md-6">
                        <label for="name">Nama Lengkap :</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" aria-describedby="validateName" placeholder="" value="{{ old('name', @$user->name) }}" disabled>
                        @error('name')
                            <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">No. Whatsapp :</label>
                        <input type="number" name="phone" min="10"
                            class="form-control @error('phone') is-invalid @enderror" id="phone"
                            aria-describedby="validateName" placeholder="" value="{{ old('phone', @$user->phone) }}" disabled>
                        @error('phone')
                            <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <hr class="divider">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-primary text-center font-weight-bold">LOKASI</p>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control " name="province_id" id="select-provinsi" disabled>
                                <option value="{{$user->provinsi?->id}}">{{$user->provinsi?->name}}</option>
                            </select>
                            @error('province_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regency_id">Kota</label>
                            <select class="form-control " name="regency_id" id="select-kota" disabled>
                                <option value="{{$user->kota?->id}}">{{$user->kota?->name}}</option>
                            </select>
                            @error('regency_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="district_id">Kecamatan</label>
                            <select class="form-control " name="district_id" id="select-kecamatan" disabled>
                                <option value="{{$user->kecamatan?->id}}">{{$user->kecamatan?->name}}</option>
                            </select>
                            @error('district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="village_id">Desa</label>
                            <select class="form-control " name="village_id" id="select-desa" disabled>
                                <option value="{{$user->desa?->id}}">{{$user->desa?->name}}</option>
                            </select>
                            @error('village_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="divider">
                
                <div class="text-center">
                    {{-- <button type="submit" class="btn btn-primary">Update Profile</button> --}}
                    <a class="btn btn-secondary" href="{{ url('pengaturan/saksi') }}">Kembali</a>
                </div>
                {{-- DARI REGISTER END --}}
            @if ($editable)
            </form>
            @endif
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

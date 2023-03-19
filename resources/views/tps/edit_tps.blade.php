@extends('layouts.main')

@section('header-content', 'Register TPS')
@section('title', 'TPS')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @php
                $url = @$tps ? 'pengaturan/tps/' . $tps->id : 'pengaturan/tps';
            @endphp
            <form action="{{ url($url) }}" method="POST" id="form-tps">
                @csrf
                @if (@$tps)
                    @method('PUT')
                @endif
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control " required name="province_id" id="select-provinsi">
                                @if (@$tps)
                                    <option value="{{ @$tps->provinsi->id }}" selected>{{ @$tps->provinsi->name }}</option>
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
                            <select class="form-control " required name="regency_id" id="select-kota">
                                @if (@$tps)
                                    <option value="{{ @$tps->kota->id }}" selected>{{ @$tps->kota->name }}</option>
                                @endif
                            </select>
                            @error('regency_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="district_id">Kecamatan</label>
                            <select class="form-control " required name="district_id" id="select-kecamatan">
                                @if (@$tps)
                                    <option value="{{ @$tps->kecamatan->id }}" selected>{{ @$tps->kecamatan->name }}
                                    </option>
                                @endif
                            </select>
                            @error('district_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="village_id">Desa</label>
                            <select class="form-control " required name="village_id" id="select-desa">
                                @if (@$tps)
                                    <option value="{{ @$tps->desa->id }}" selected>{{ @$tps->desa->name }}</option>
                                @endif
                            </select>
                            @error('village_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nomor">Nomor/Keterangan</label>
                            <input type="text" class="form-control" name="nomor"
                                value="{{ old('nomor', @$tps->nomor) }}" id="nomor"/>
                            @error('nomor')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>

                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('pengaturan/tps') }}" class="btn btn-secondary">Kembali</a>
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
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
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

            const notifySuccess = (title = "") => {
                Swal.fire({
                    position: 'top-end',
                    toast: true,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    icon: 'success',
                    title: title,
                })
            }

            const notifyError = (title = "") => {
                Swal.fire({
                    position: 'top-end',
                    toast: true,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    icon: 'error',
                    title: title,
                })
            }

        });
    </script>
@endsection

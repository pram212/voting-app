<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register - {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('images/prams_brand.png')}}">

    <!-- Custom fonts for this template-->
    <link href="{{asset('template/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('template/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-header">
                        <h4 class="text-center">
                            PENDAFTARAN SAKSI
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/register') }}" method="POST">
                            @csrf
                            <div class="row">
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
                                <p class="py-2">sudah punya akun? <a href="{{url('login')}}">Login</a></p>
                            </div>
            
                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('template/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>


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

</body>

</html>

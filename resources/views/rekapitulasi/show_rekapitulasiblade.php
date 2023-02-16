@extends('layouts.main')

@section('header-content', 'Biodata Pengguna')
@section('title', 'Pengguna')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">Nama Lengkap :</label>
                    <input type="text" name="name" class="form-control" id="name" aria-describedby="validateName"
                        placeholder="" readonly value="{{ old('name', @$user->name) }}">
                    @error('name')
                        <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">No. Whatsapp :</label>
                    <input type="number" name="phone" class="form-control" id="phone" aria-describedby="validateName"
                        placeholder="" readonly value="{{ old('phone', @$user->phone) }}">
                    @error('phone')
                        <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Email :</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" readonly value="{{ old('email', @$user->email) }}">
                    @error('email')
                        <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Role :</label>
                    <select class="custom-select" name="role" disabled>
                        <option value="2" @if (old('role', @$user->role) == 2) selected @endif>Saksi</option>
                        <option value="1" @if (old('role', @$user->role) == 1) selected @endif>Admin</option>
                    </select>
                    @error('role')
                        <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <hr class="divider">

            <div class="text-center">
                <a href="{{ url('user') }}" class="btn btn-primary"><i class="fas fa-backward"></i> Kembali</a>
                <a href="#" class="btn btn-warning" id="btn-chat"><i class="fa fa-comment" aria-hidden="true"></i> Hubungi</a>
            </div>
        </div>
    </div>

    <form action="https://wa.me/{{formatNoHp($user->phone)}}" target="_blank" method="get" id="form-chat" class="d-none">
        <textarea name="text" id="" cols="30" rows="10">
Hai, Kami dari Web TPS. 
Anda Sudah terdaftar dalam sistem kami. 
Silahkan Login dengan
No. Telepon: {{$user->phone}}
Password :</textarea>
    </form>
@endsection

@section('css')

@endsection

@section('script')
    <script>
        $("#btn-chat").click(function (e) { 
            e.preventDefault();
            $("#form-chat").submit();
        });
    </script>
@endsection

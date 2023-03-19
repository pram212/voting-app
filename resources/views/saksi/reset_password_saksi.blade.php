@extends('layouts.main')

@section('header-content', 'Reset Password')
@section('title', 'Reset Password')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('user.updatepassword', $user->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="name">Nama :</label>
                        <input type="text" class="form-control" id="name" disabled value="{{$user->name}}">
                        
                    </div>
                    <div class="form-group col-md-12">
                        <label for="name">No WA :</label>
                        <input type="text" class="form-control" id="phone" disabled value="{{$user->phone}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="password">Masukan Password Baru :</label>
                        <input type="text" name="password" class="form-control" id="password"
                            aria-describedby="validateName" placeholder="">
                        @error('password')
                            <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ url('/pengaturan/saksi') }}" class="btn btn-secondary"><i class="fas fa-backward"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <form action="https://wa.me/{{ formatNoHp($user->phone) }}" target="_blank" method="get" id="form-chat"
        class="d-none">
        <textarea name="text" id="" cols="30" rows="10">
Hai, Kami dari Web TPS. 
Anda Sudah terdaftar dalam sistem kami. 
Silahkan Login dengan
No. Telepon: {{ $user->phone }}
Password :</textarea>
    </form>
@endsection

@section('css')

@endsection

@section('script')
    <script>
        $("#btn-chat").click(function(e) {
            e.preventDefault();
            $("#form-chat").submit();
        });
    </script>
@endsection

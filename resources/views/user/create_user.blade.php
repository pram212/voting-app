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
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
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
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('css')

@endsection

@section('script')

@endsection

@extends('layouts.main')

@section('header-content', 'Register jabatan')
@section('title', 'jabatan')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('jabatan.update', @$jabatan->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="nama">Nama Lengkap :</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            id="nama" aria-describedby="validateName" placeholder="" value="{{ old('nama', @$jabatan->nama) }}">
                        @error('nama')
                            <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                   
                </div>

                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('jabatan') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('script')
    
@endsection

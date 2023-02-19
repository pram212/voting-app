@extends('layouts.main')

@section('header-content', 'Register Provinsi')
@section('title', 'Provinsi')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @php
                $url = @$provinsi ? 'provinsi/' . $provinsi->id : 'provinsi'; 
            @endphp
            <form action="{{ url($url) }}" method="POST">
                @csrf

                @if (@$provinsi)
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nama">Nama :</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name" placeholder="" value="{{old('name', @$provinsi->name)}}">
                        @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('provinsi') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
@endsection

@extends('layouts.main')

@section('header-content', 'Register Calon')
@section('title', 'Calon')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ url('calon') }}" method="POST">
                @php
                    $url = @$calon ? 'calon/' . $calon->id : 'tps'; 
                @endphp
                @csrf

                @if (@$calon)
                    @method('PUT')
                @endif
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="no_urut">Nomor Urut :</label>
                        <input type="number" name="no_urut" class="form-control @error('no_urut') is-invalid @enderror"
                        id="no_urut" aria-describedby="validateName" placeholder="" value="{{old('keterangan', @$calon->no_urut)}}">
                        @error('no_urut')
                        <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="keterangan">Keterangan :</label>
                        <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                            id="keterangan" aria-describedby="validateName" placeholder="pasangan calon fulan dan fulan" value="{{old('keterangan', @$calon->keterangan)}}">
                        @error('keterangan')
                            <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <hr class="divider">

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('calon') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
@endsection

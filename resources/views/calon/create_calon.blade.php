@extends('layouts.main')

@section('header-content', 'Register Calon')
@section('title', 'Calon')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ url('calon') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nama">Nama Lengkap :</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                            id="nama" aria-describedby="validateName" placeholder="" value="{{ old('nama') }}">
                        @error('nama')
                            <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="no_urut">No. Urut :</label>
                        <input type="number" name="no_urut" class="form-control @error('no_urut') is-invalid @enderror"
                            id="no_urut" aria-describedby="validateName" placeholder="" value="{{ old('no_urut') }}">
                        @error('no_urut')
                            <small id="validateName" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Jabatan :</label>
                        <select class="custom-select select2 @error('role') is-invalid @enderror" name="jabatan_id">
                        </select>
                        @error('jabatan_id')
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

@section('css')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@endsection

@section('script')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $('.select2').select2({
            ajax: {
                url: '/select2/getjabatan',
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });
    </script>
@endsection

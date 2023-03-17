@extends('layouts.main')

@section('header-content', 'Data TPS')
@section('title', 'TPS')

@section('content')
    {{-- FILTER PANEL --}}
    <div class="card shado mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Filter
            </h6>
        </div>
        <div class="card-body">
            <form action="" id="form-filter">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control select2" name="province_id" id="select-provinsi" style="width:100%">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="regency_id">Kota</label>
                            <select class="form-control select2" name="regency_id" id="select-kota">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="district_id">Kecamatan</label>
                            <select class="form-control select2" name="district_id" id="select-kecamatan">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="village_id">Desa</label>
                            <select class="form-control select2" name="village_id" id="select-desa">
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="sidebar-divider">

                <button class="btn btn-primary" type="submit">Tampilkan</button>
                <a class="btn btn-danger" href="">Reset</a>

            </form>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ url('tps/create') }}" class="btn btn-success">Register</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No. TPS</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/filter_location.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        
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

        tpsTable = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/tps',
            columns: [{
                    data: 'nomor'
                },
                {
                    data: 'provinsi.name'
                },
                {
                    data: 'kota.name'
                },
                {
                    data: 'kecamatan.name'
                },
                {
                    data: 'desa.name'
                },
                {
                    data: 'action'
                },
            ],
        });

        // filter event
        $("#form-filter").submit(function(e) {
            e.preventDefault();
            formElemetns = e.target.elements;
            console.log(formElemetns)
            const requestFom =
                `?province_id=${formElemetns.province_id.value}&regency_id=${formElemetns.regency_id.value}&district_id=${formElemetns.district_id.value}&village_id=${formElemetns.village_id.value}`
            tpsTable.ajax.url('/tps' + requestFom).load();

        });

        // function delete detail
        $('#dataTable tbody').on('click', 'button.btn-delete', function() {
            var tr = $(this).closest('tr');
            var data = tpsTable.row(tr).data();
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "tps/" + data.id,
                        type: 'delete',
                        dataType: "json",
                        success: function(response) {
                            notifySuccess(response)
                            tpsTable.ajax.reload();
                        }
                    })
                }
            })
        });
    </script>

@endsection

@extends('layouts.main')

@section('header-content', 'Daftar Calon')
@section('title', 'Calon')

@section('content')
    {{-- FILTER PANEL --}}
    {{-- <div class="card shado mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Filter
            </h6>
        </div>
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jabatan_id">Jabatan</label>
                            <select class="form-control select2" name="jabatan_id" value="{{ @request('jabatan_id') }}">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control form-control-sm" name="jabatan_id" value="{{ @request('nama') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="no_urut">No. Urut</label>
                            <input type="number" name="no_urut" id="no_urut" class="form-control form-control-sm" name="no_urut" value="{{ @request('no_urut') }}">
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm btn-primary mx-2">Tampilkan</button>
                        <a href="{{url('calon')}}" class="btn btn-sm btn-danger">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <a href="{{ url('calon/create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Register
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Nomor Urut</th>
                            <th>Keterangan</th>
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

    <!-- Page level custom scripts -->
    <script>

        $(document).ready(function () {
            
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
    
            $('.select2').select2({
                ajax: {
                    url: '/select2/getjabatan',
                    dataType: 'json'
                }
            });
    
            calonTable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/calon',
                columns: [{
                        data: 'no_urut'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'action'
                    },
                ],
            });
    
            // function delete detail
            $('#dataTable tbody').on('click', 'button.btn-delete', function() {
                var tr = $(this).closest('tr');
                var data = calonTable.row(tr).data();
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
                            url: "calon/" + data.id,
                            type: 'delete',
                            dataType: "json",
                            success: function(response) {
                                notifySuccess(response)
                                calonTable.ajax.reload();
                            }
                        })
                    }
                })
            });


        });
    </script>

@endsection

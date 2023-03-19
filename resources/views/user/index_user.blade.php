@extends('layouts.main')

@section('header-content', 'Daftar Admin')
@section('title', 'Pengaturan')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-flex justify-content-between">
                <a href="{{ url('pengaturan/user/create') }}" class="btn btn-success">
                    Register
                </a>
                {{-- <a href="{{ url('pengaturan') }}" class="btn btn-secondary">
                    Kembali Ke Pengaturan
                </a> --}}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Nama</th>
                            <th>No. Telepon</th>
                            <th>Role</th>
                            <th>Registrasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        var userTable = $('#dataTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '/datatable/user',
                        columns: [{
                                data: 'name'
                            },
                            {
                                data: 'phone'
                            },
                            {
                                data: 'role'
                            },
                            {
                                data: 'created_at'
                            },
                            {
                                data: 'action'
                            },
                        ],
                    });

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

        // function delete detail
        $('#dataTable tbody').on('click', 'button.btn-delete', function() {
            var tr = $(this).closest('tr');
            var data = userTable.row(tr).data();
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
                        url: "/pengaturan/user/" + data.id,
                        type: 'delete',
                        dataType: "json",
                        success: function(response) {
                            notifySuccess(response)
                            userTable.ajax.reload();
                        }
                    })
                }
            })
        });
    </script>
@endsection

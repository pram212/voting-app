@extends('layouts.main')

@section('header-content', 'Daftar Provinsi')
@section('title', 'Provinsi')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <a href="{{ url('provinsi/create') }}" class="btn btn-success">
                    Register
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
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
    
            provinsiTable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/provinsi',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {
                        data: 'name'
                    },
                    {
                        data: 'action'
                    },
                ],
            });
    
            // function delete detail
            $('#dataTable tbody').on('click', 'button.btn-delete', function() {
                var tr = $(this).closest('tr');
                var data = provinsiTable.row(tr).data();
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
                            url: "provinsi/" + data.id,
                            type: 'delete',
                            dataType: "json",
                            success: function(response) {
                                notifySuccess(response)
                                provinsiTable.ajax.reload();
                            }
                        })
                    }
                })
            });


        });
    </script>

@endsection

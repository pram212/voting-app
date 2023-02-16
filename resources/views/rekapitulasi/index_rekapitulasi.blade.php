@extends('layouts.main')

@section('header-content', 'Tabel Rekapitulasi')
@section('title', 'Rekapitulasi')

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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="calon_pejabat_id">Calon</label>
                            <select class="form-control select2" name="calon_pejabat_id" id="select-calon">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jabatan_id">Jabatan</label>
                            <select class="form-control select2" name="jabatan_id" id="select-jabatan">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control select2" name="province_id" id="select-provinsi">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="regency_id">Kota</label>
                            <select class="form-control select2" name="regency_id" id="select-kota">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="district_id">Kecamatan</label>
                            <select class="form-control select2" name="district_id" id="select-kecamatan">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="village_id">Desa</label>
                            <select class="form-control select2" name="village_id" id="select-desa">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="user_id">Saksi</label>
                            <select class="form-control select2" name="user_id" id="select-user">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-primary" type="submit">Tampilkan</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Hasil Perhitungan
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Jabatan</th>
                            <th>Nama</th>
                            <th>Suara</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>RT</th>
                            <th>RW</th>
                            <th>Saksi</th>
                            <th>Tanggal</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

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

        // setup select option ajax
        $('#select-calon').select2({
            ajax: {
                url: '/select2/getcalon',
                dataType: 'json'
            }
        });

        $('#select-jabatan').select2({
            ajax: {
                url: '/select2/getjabatan',
                dataType: 'json'
            }
        });

        $('#select-provinsi').select2({
            ajax: {
                url: '/select2/getprovinsi',
                dataType: 'json'
            }
        });

        $('#select-kota').select2({
            ajax: {
                url: '/select2/getkota',
                dataType: 'json'
            }
        });

        $('#select-kecamatan').select2({
            ajax: {
                url: '/select2/getkecamatan',
                dataType: 'json'
            }
        });

        $('#select-desa').select2({
            ajax: {
                url: '/select2/getdesa',
                dataType: 'json'
            }
        });

        $('#select-user').select2({
            ajax: {
                url: '/select2/getuser',
                dataType: 'json'
            }
        });

        calonTable = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/rekapitulasi',
            columns: [
                { data: 'jabatan' },
                { data: 'calon_pejabat.nama' },
                { data: 'jumlah_suara' },
                { data: 'provinsi.name' },
                { data: 'kota.name' },
                { data: 'kecamatan.name' },
                { data: 'desa.name' },
                { data: 'rt' },
                { data: 'rw' },
                { data: 'user.name' },
                { data: 'created_at' },
                { data: 'action' },
            ],
        });

        // filter event
        $("#form-filter").submit(function(e) {
            e.preventDefault();
            formElemetns = e.target.elements;
            console.log(formElemetns)
            const requestFom =
                `?calon_pejabat_id=${formElemetns.calon_pejabat_id.value}&province_id=${formElemetns.province_id.value}&regency_id=${formElemetns.regency_id.value}&district_id=${formElemetns.district_id.value}&village_id=${formElemetns.village_id.value}&user_id=${formElemetns.user_id.value}`
            calonTable.ajax.url('/rekapitulasi' + requestFom).load();

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
    </script>

@endsection

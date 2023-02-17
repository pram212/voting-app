@extends('layouts.main')

@section('header-content', 'Hasil Rekapitulasi TPS')
@section('title', 'Rekapitulasi')

@section('content')
    {{-- FILTER PANEL --}}
    @if (auth()->user()->role == 1)
        <div class="card shadow mb-4">
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
    @endif
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fa fa-map-marker mr-3" aria-hidden="true"></i>
                {{ auth()->user()->provinsi->name }} {{ auth()->user()->kota->name }} /
                {{ auth()->user()->kecamatan->name }} / {{ auth()->user()->desa->name }}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover dt-responsive display nowrap" style="width: 100%" cellspacing="0" id="dataTable">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th></th>
                            <th>Keterangan</th>
                            <th>RT</th>
                            <th>RW</th>
                            <th>Total Suara</th>
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

        function format(d) {
            // `d` is the original data object for the row
            let element = `<div class="row">`;

            $.each(d.calon, function(indexInArray, valueOfElement) {
                element += `
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">Nomor Urut ${valueOfElement.no_urut}</div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th>Calon</th>
                                    <td>${valueOfElement.keterangan}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Suara</th>
                                    <td>${valueOfElement.pivot.jumlah_suara} </td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>${valueOfElement.pivot.keterangan ?? '-'}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                `
            });

            element += `</div>`

            return (element);
        }

        calonTable = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            searching: false,
            responsive: false,
            ajax: '/rekapitulasi',
            columns: [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: '',
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'rt'
                },
                {
                    data: 'rw'
                },
                {
                    data: 'total_suara'
                },
                {
                    data: 'action'
                },
            ],
        });

        // Add event listener for opening and closing details
        $('#dataTable tbody').on('click', 'td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = calonTable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
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

@extends('layouts.main')

@section('header-content', 'Hasil Rekapan TPS')
@section('title', 'Rekapitulasi')

@section('content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <div class="text-xs">PROVINSI {{ auth()->user()->provinsi->name }}</div>
                <div class="text-xs">{{ auth()->user()->kota->name }}</div>
                <div class="text-xs">KECAMATAN {{ auth()->user()->kecamatan->name }}</div>
                <div class="text-xs">DESA {{ auth()->user()->desa->name }}</div>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="display responsive nowrap" width="100%" id="table-saksi">
                    <thead class="bg-dark text-white text-center">
                        <tr>
                            <th class="align-middle">TPS</th>
                            @foreach ($headerCalon as $item)
                                <th class="align-middle">{{ strtoupper($item->keterangan) }}</th>
                            @endforeach
                            <th>Total</th>
                            <th class="align-middle">CATATAN</th>
                            <th class="align-middle">OPSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($rekapitulasi as $item)
                            <tr>
                                <td>{{ $item->nomor }}</td>
                                @foreach ($item->calon as $calon)
                                    <td class="font-weight-bold">{{ $calon->pivot->jumlah_suara }}</td>
                                @endforeach
                                <td>{{ $item->calon->sum('pivot.jumlah_suara') }}</td>
                                <td>{{ $item->catatan }}</td>
                                <th>
                                    <a href="{{ url('rekapitulasi/' . $item->id . '/edit') }}"
                                        class="btn btn btn-info">
                                        @can('update', $item)
                                            Lihat
                                        @else
                                            Entry
                                        @endcan
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $rekapitulasi->onEachSide(5)->links() }}
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

    <script>
        $('#table-saksi').DataTable( { 
            responsive: true,
            paging: false
        })
    </script>
    
@endsection

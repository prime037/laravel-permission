@extends('master.index')
@section('content')
    <div class="table-responsive m-5 p-5">
        {{-- Export, import, restore, dan create button --}}
        <div>
            <a href= "/home" class=" btn btn-warning">Kembali</a>
        </div>
        {{-- Tabel barang --}}
        <table class="table table-row-dashed table-row-gray-300 gy-7 table-striped align-middle" id="barang">
            <thead>
                <tr class="fw-bold fs-6 text-gray-800">
                    <th>Id</th>
                    <th>Name</th>
                    <th>Jumlah</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $d)
                    <tr class="fs-6">
                        <td>{{$d->id}}</td>
                        <td>{{$d->name}}</td>
                        <td>{{$d->jumlah}}</td>
                        <td><a href="/restore_barang/{{$d->id}}" class="btn-sm btn btn-success">Restore</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No Deleted Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
@section('scripts')
    
@endsection
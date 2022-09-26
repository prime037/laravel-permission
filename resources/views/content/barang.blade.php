@extends('master.index')
@section('content')

<div class="table-responsive m-5 p-5">
    <a href= "/exportExcel" class=" btn btn-success">Export</a>
    <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_1">Import</button>
    <table class="table table-row-dashed table-row-gray-300 gy-7 table-striped" id="barang">
     <thead>
        <tr class="fw-bold fs-6 text-gray-800">
            <th>No</th>
            <th>Name</th>
            <th>Jumlah</th>
        </tr>
     </thead>
     <tbody>

     </tbody>
    </table>
</div>

    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Modal title</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form action="/importExcel" class="form" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="import" class="required form-label">Example</label>
                            <input type="file" class="form-control form-control-solid" id="import" name="import"/>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
         $(document).ready( function () {
            $('#barang').DataTable(
                {
                    processing: true,
                    serverSide: true,
                    language: {
                        lengthMenu: "Show _MENU_",
                    },
                    dom:
                    "<'row'" +
                    "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                    "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                    ">" +

                    "<'table-responsive'tr>" +

                    "<'row'" +
                    "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                    "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                    ">",
                    ajax: `{{ route('getBarang') }}`,
                    columns: [
                        { data: 'rownum' },
                        { data: 'name'},
                        { data: 'jumlah'}
                    ]
                }
            );
        });
    </script>
@endsection
@extends('master.index')
@section('content')
    <div class="table-responsive m-5 p-5">
        {{-- Export, import, dan create button --}}
        <div>
            <a href= "/exportExcel" class=" btn btn-success">Export</a>
            <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalexcel">Import</button>
            <button class="btn btn-success" style="float:right" onclick="showCreate()">Create</button>
        </div>
        {{-- Tabel barang --}}
        <table class="table table-row-dashed table-row-gray-300 gy-7 table-striped" id="barang">
            <thead>
                <tr class="fw-bold fs-6 text-gray-800">
                    <th>No</th>
                    <th>Name</th>
                    <th>Jumlah</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    {{-- Modal export dan import --}}
    <div class="modal fade" tabindex="-1" id="modalexcel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Import Data from Excel</h3>

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
                            <label for="import" class="required form-label">Import File</label>
                            <input type="file" class="form-control form-control-solid" id="import" name="import"/>
                            <label for="#" class="mt-1 required form-label">Download template,<a href="/template">click here</a></label>
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
    {{-- Modal create --}}
    <div class="modal fade" tabindex="-1" id="showCreateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Create Data</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="#" id="createform" class="form">
                    <div class="modal-body">
                        <div class="fv-row">
                            <label for="import" class="required form-label">Nama Barang</label>
                            <input type="text" class="form-control form-control-solid" id="name" name="name"/>
                        </div>
                        <div class="fv-row">
                            <label for="import" class="required form-label">Jumlah Barang</label>
                            <input type="number" class="form-control form-control-solid" id="jumlah" name="jumlah"/>
                        </div>
                    </div>
                    

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="create()" id="create_button">
                            <span class="indicator-label">
                                Create
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Edit --}}
    <div class="modal fade" tabindex="-1" id="showEditModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit Data</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form action="#" id="editform" class="form">
                    <div class="modal-body">
                        <div class="fv-row">
                            <label for="import" class="required form-label">Nama Barang</label>
                            <input type="text" class="form-control form-control-solid" id="edit_name" name="edit_name"/>
                        </div>
                        <div class="fv-row">
                            <label for="import" class="required form-label">Jumlah Barang</label>
                            <input type="number" class="form-control form-control-solid" id="edit_jumlah" name="edit_jumlah"/>
                        </div>
                    </div>
                    <input type="hidden" value="" id="id_edit">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="edit()" id="edit_button">
                            <span class="indicator-label">
                                Edit
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{-- script datatables --}}
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
                        { data: 'jumlah'},
                        { data: 'id'},
                    ],
                    columnDefs: [
                        {
                            "targets": -1,
                            "render": function ( data, type, row ) {
                                return `
                                    <a onclick="showModalEdit(` + row['id'] + `)" id="` + row['id'] +`" type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                        <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>

                                    <button type="button"  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="hapus(`+ row['id'] +`)">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </button>
                                `
                            }
                        }
                    ]
                }
            );
        });
    </script>
    {{-- script create --}}
    <script>
        function showCreate(){
            $('#showCreateModal').modal('show');
        }
        // Define form element
        const form = document.getElementById('createform');
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Text input is required'
                            },
                            stringLength:{
                                min:4,
                                message: "Atleast 4 character"
                            }
                        }
                    },
                    'jumlah': {
                        validators: {
                            notEmpty: {
                                message: 'Jumlah input is required'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Submit button handler
        const submitButton = document.getElementById('create_button');
        // submitButton.addEventListener('click', function (e) {
        //     // Prevent default button action
        //     e.preventDefault();

        //     // Validate form before submit
        //     if (validator) {
        //         validator.validate().then(function (status) {
        //             console.log('validated!');

        //             if (status == 'Valid') {
        //                 // Show loading indication
        //                 submitButton.setAttribute('data-kt-indicator', 'on');

        //                 // Disable button to avoid multiple click
        //                 submitButton.disabled = true;

        //                 // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
        //                 setTimeout(function () {
        //                     // Remove loading indication
        //                     submitButton.removeAttribute('data-kt-indicator');

        //                     // Enable button
        //                     submitButton.disabled = false;

        //                     // Show popup confirmation
        //                     Swal.fire({
        //                         text: "Form has been successfully submitted!",
        //                         icon: "success",
        //                         buttonsStyling: false,
        //                         confirmButtonText: "Ok, got it!",
        //                         customClass: {
        //                             confirmButton: "btn btn-primary"
        //                         }
        //                     });

        //                     //form.submit(); // Submit form
        //                 }, 2000);
        //             }
        //         });
        //     }
        // });
        function create(){
            let name = $('#name').val();
            let jumlah = $('#jumlah').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            if (validator) {
                validator.validate().then(function (status) {
                    console.log(status);
                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        submitButton.disabled = true;

                        // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        setTimeout(function () {
                            // Remove loading indication
                            submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            submitButton.disabled = false;

                            // Show popup confirmation
                            $.ajax({
                                type:'POST',
                                url:"{{ route('create_barang') }}",
                                data:{
                                    name: name,
                                    jumlah: jumlah,
                                    _token: _token
                                },
                                success:function(response){
                                    if(response.status === false) {
                                        Swal.fire({
                                            text: response.data,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            text: "Sukses!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                        $('#showCreateModal').modal('hide');
                                        $("#createform")[0].reset();
                                        $("#barang").DataTable().ajax.reload();
                                    }
                                }
                            })
                        }, 2000);
                    }
                });
            }else{
                Swal.fire({
                    text: "Check data!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
            
        }
    </script>
    {{-- script edit --}}
    <script>
        function showModalEdit(id){
            let _token = $('meta[name="csrf-token"]').attr('content');
            $('#id_edit').val(id);
            $.ajax({
                type: "POST",
                url: "{{route('showEditBarang')}}",
                data:{
                    id: id,
                    _token: _token
                },
                success: function(response){
                        // $('#idEdit').val(response.data.id);
                        $('#edit_name').val(response.data.name);
                        $('#edit_jumlah').val(response.data.jumlah);
                }
            });
            $('#showEditModal').modal('show');
        }

        // Define form element
        const edit_form = document.getElementById('editform');
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator_edit = FormValidation.formValidation(
            edit_form,
            {
                fields: {
                    'edit_name': {
                        validators: {
                            notEmpty: {
                                message: 'Text input is required'
                            },
                            stringLength:{
                                min:4,
                                message: "Atleast 4 character"
                            }
                        }
                    },
                    'edit_jumlah': {
                        validators: {
                            notEmpty: {
                                message: 'Jumlah input is required'
                            }
                        }
                    }
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Submit button handler
        const editButton = document.getElementById('edit_button');

        function edit(){
            let edit_name = $('#edit_name').val();
            let edit_jumlah = $('#edit_jumlah').val();
            let id = $('#id_edit').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            console.log(id);
            if (validator_edit) {
                validator_edit.validate().then(function (status) {
                    console.log(status);
                    if (status == 'Valid') {
                        // Show loading indication
                        editButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click
                        editButton.disabled = true;

                        // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        setTimeout(function () {
                            // Remove loading indication
                            editButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            editButton.disabled = false;

                            // Show popup confirmation
                            $.ajax({
                                type:'POST',
                                url:"{{ route('update_barang') }}",
                                data:{
                                    edit_name: edit_name,
                                    edit_jumlah: edit_jumlah,
                                    _token: _token,
                                    id: id
                                },
                                success:function(response){
                                    if(response.status === false) {
                                        Swal.fire({
                                            text: response.data,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                    }else{
                                        Swal.fire({
                                            text: "Sukses!",
                                            icon: "success",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                        $('#showEditModal').modal('hide');
                                        $("#editform")[0].reset();
                                        $("#barang").DataTable().ajax.reload();
                                    }
                                }
                            })
                        }, 2000);
                    }
                });
            }else{
                Swal.fire({
                    text: "Check data!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
            
        }
    </script>
    {{-- script delete --}}
    <script>
        function hapus(id){
            Swal.fire({
                text: `Delete?`,
                icon: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Delete!",
                cancelButtonText: 'Nope, cancel it',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '{{route('delete_barang')}}',
                        data:{
                            id : id,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response){
                            $('#barang').DataTable().ajax.reload();
                        }
                    })
                    Swal.fire('Deleted!', '', 'success')
                }
            })  
        }
    </script>
@endsection
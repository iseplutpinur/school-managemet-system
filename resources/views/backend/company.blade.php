@extends('admin.admin_master')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="d-md-flex flex-row justify-content-between">
                <h3 class="box-title">Company List</h3>
                <button type="button" class="btn btn-rounded btn-success" data-toggle="modal" onclick="add()"
                    data-target="#modal-default">
                    <i data-feather="plus"></i> Add
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table id="tbl_main" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- modal Area -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded15">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Company Name"
                                maxlength="50" required="">
                        </div>
                        <div class="form-group">
                            <label for="name">Company Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter Company Email" maxlength="50" required="">
                        </div>
                        <div class="form-group">
                            <label>Company Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Enter Company Address" required="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">
                        <li class="fa fa-times "></li> Close
                    </button>
                    <button type="submmit" class="btn btn-rounded btn-primary float-right" id="btn-save" form="CompanyForm">
                        <li class="fa fa-save mr-1"></li> Save changes
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content rounded15">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-default-title">Delete Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Delete Record</p>
                    <form action="javascript:void(0)" id="deleteForm" name="deleteForm" class="form-horizontal"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="delete_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-danger" data-dismiss="modal">
                        <li class="fa fa-times "></li> Close
                    </button>
                    <button type="submmit" class="btn btn-rounded btn-primary float-right" id="btn-save-delete"
                        form="deleteForm">
                        <li class="fa fa-trash mr-1"></li> Delete
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('javascript')
    <script src="{{ asset('backend/assets/vendor_components/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            const table_html = $('#tbl_main');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const new_table = table_html.DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('company') }}",
                columns: [{
                        data: null,
                        name: 'id',
                        orderable: false,
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'id',
                        render(data, type, full, meta) {
                            return `
                            <button type="button" class="btn btn-rounded btn-primary" title="Edit Data" onClick="editFunc('${data}')">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                            </button>
                            <button type="button" class="btn btn-rounded btn-danger" title="Delete Data" onClick="deleteFunc('${data}')">
                                <i class="fa fa-trash" aria-hidden="true"></i> Delete
                            </button>
                        `;
                        },
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [1, 'asc']
                ]
            });
            new_table.on('draw.dt', function() {
                var PageInfo = table_html.DataTable().page.info();
                new_table.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                });
            });

            $('#CompanyForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                setBtnLoading('#btn-save', 'Save Changes');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('store-company') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $.toast({
                            heading: 'Success',
                            text: 'Data saved successfully',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                        $("#modal-default").modal('hide');
                        var oTable = table_html.dataTable();
                        oTable.fnDraw(false);
                    },
                    error: function(data) {
                        $.toast({
                            heading: 'Failed',
                            text: 'Data failed to add',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    },
                    complete: function() {
                        setBtnLoading('#btn-save',
                            '<li class="fa fa-save mr-1"></li> Save changes',
                            false);
                    }
                });
            });

            $('#deleteForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                setBtnLoading('#btn-save-delete', 'Delete');
                $.ajax({
                    type: "POST",
                    url: "{{ url('delete-company') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res) {
                        $.toast({
                            heading: 'Success',
                            text: 'Data deleted successfully',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                        var oTable = table_html.dataTable();
                        oTable.fnDraw(false);
                    },
                    error: function(data) {
                        $.toast({
                            heading: 'Failed',
                            text: 'Data failed to delete-delete',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'error',
                            hideAfter: 3500,
                            stack: 6
                        });
                    },
                    complete: function() {
                        setBtnLoading('#btn-save-delete',
                            '<li class="fa fa-trash mr-1"></li> Delete',
                            false);

                        $('#modal-delete').modal('hide');
                    }
                });
            });
        });

        function add() {
            $('#CompanyForm').trigger("reset");
            $('#modal-default-title').html("Add Company");
            $('#modal-default').modal('show');
            $('#id').val('');
        }

        function editFunc(id) {
            $.ajax({
                type: "POST",
                url: "{{ url('edit-company') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#modal-default-title').html("Edit Company");
                    $('#modal-default').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#address').val(res.address);
                    $('#email').val(res.email);
                }
            });
        }

        function deleteFunc(id) {
            $('#delete_id').val(id);
            $('#modal-delete').modal('show');
        }
    </script>
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor_components/datatable/datatables.min.css') }}">
@endsection

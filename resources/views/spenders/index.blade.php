@extends('adminlte::page')

@section('title', 'النفقات')

@section('content')
    <div class="modal fade" id="edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل منفق</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="edit-form">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="form-group">
                            <label for="edit-spender-name">اسم المنفق</label>
                            <input type="text" name="name" id="edit-spender-name" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">غلق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="create-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة منفق</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="create-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-spender-name">اسم المنفق</label>
                            <input type="text" name="name" id="create-spender-name" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">غلق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                    </div>
                    <div class="col-4 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-modal">اضافة
                            منفق</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

@stop

@section('css')
    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('plugins.Datatables', true)
@section('plugins.Toastr', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
<script src="{{ asset('js/functions.js') }}"></script>

@section('js')
    <script>
        $(document).on('click', '.edit-btn', function() {
            $('#edit-id').val($(this).data('id'));
            $('#edit-spender-name').val($(this).data('spender_name'));
        });
        $('#edit-form').submit(function(event) {
            event.preventDefault();
            let id = $('#edit-id').val();
            let name = $('#edit-spender-name').val();
            axios.patch('{{ route('spenders.update', ['spender' => 0]) }}' + id, {
                    name
                })
                .then(function(response) {
                    toastr.success(response.data.message);
                    refreshDatatable();
                })
                .catch(function(error) {
                    toastr.error(error.response.data.message);
                });
        });
        $('#create-form').submit(function(event) {
            event.preventDefault();
            let name = $('#create-spender-name').val();

            axios.post('{{ route('spenders.store') }}', {
                    name,
                })
                .then(function(response) {
                    toastr.success(response.data.message);
                    refreshDatatable();
                })
                .catch(function(error) {
                    console.log(error.response)
                    var errors = error.response.data.errors;
                    var errorMessages = '';
                    Object.keys(errors).forEach(function(key) {
                        errorMessages += errors[key][0] + '<br>';
                    });

                    toastr.error(errorMessages, '', {
                        "timeOut": "5000",
                        "extendedTImeout": "2000",
                    });
                    toastr.error(error.response.data.message);

                });
        });
    </script>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

@stop

@extends('adminlte::page')

@section('title', 'النفقات')

@section('content')
    <div class="modal fade" id="edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تعديل نفقة</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="edit-form">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        <div class="form-group">
                            <label for="edit-expense-name">انفق في</label>
                            <input type="text" name="name" id="edit-expense-name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit-amount">المبلغ</label>
                            <input type="number" name="amount" id="edit-amount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit-date">التاريخ</label>
                            <input type="date" name="date" id="edit-date" class="form-control">
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
                    <h4 class="modal-title">اضافة نفقة</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="create-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-expense-name">انفق في</label>
                            <input type="text" name="name" id="create-expense-name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="create-amount">المبلغ</label>
                            <input type="number" name="amount" id="create-amount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="create-date">التاريخ</label>
                            <input type="date" name="date" id="create-date" class="form-control">
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
        <div class="card d-inline-block">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                    </div>
                    <div class="col-4 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create-modal">اضافة
                            نفقة</button>
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
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="/css/admin_custom.css">
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
            $('#edit-expense-name').val($(this).data('expense_name'));
            $('#edit-amount').val($(this).data('amount'));
            $('#edit-date').val($(this).data('date'));
        });
        $('#edit-form').submit(function(event) {
            event.preventDefault();
            let id = $('#edit-id').val();
            let expense_name = $('#edit-expense-name').val();
            let amount = $('#edit-amount').val();
            let date = $('#edit-date').val();
            axios.patch('{{ route('house-expenses.update', ['house_expense' => 0]) }}' + id, {
                    amount,
                    date,
                    expense_name
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
            let expense_name = $('#create-expense-name').val();
            let amount = $('#create-amount').val();
            let date = $('#create-date').val();
            axios.post('{{ route('house-expenses.store') }}', {
                    expense_name,
                    amount,
                    date,
                    house_name: '{{ $house }}'
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

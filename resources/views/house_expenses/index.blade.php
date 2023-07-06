@extends('adminlte::page')

@section('title', 'النفقات')

@section('content')
    <h3>مجموع ما انفق على المنزل {{ $sum_expenses }} دينار</h3>
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
                            <select name="edit_spender" id="edit_spender_select" class="form-control select2">
                            </select>
                            <label for="edit_spender_select">اسم المنفق</label>
                        </div>
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
                            <select name="create_spender" id="create_spender_select" class="form-control select2">
                            </select>
                            <label for="create_spender_select">اسم المنفق</label>
                        </div>
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
        $(document).ready(function() {
            $('#create_spender_select').select2({
                placeholder: "Select an option",
                allowClear: true,
                minimumInputLength: 2,
                delay: true,
                cache: true,
                ajax: {
                    url: "{{ route('select.employees') }}",
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function({
                                text,
                                id
                            }) {
                                return {
                                    text,
                                    id
                                }
                            }),
                            pagination: {
                                more: data.next_page_url
                            }
                        };
                    }
                }
            });
            $('#edit_spender_select').select2({
                placeholder: "Select an option",
                allowClear: true,
                minimumInputLength: 2,
                delay: true,
                cache: true,
                ajax: {
                    url: "{{ route('select.employees') }}",
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: $.map(data.data, function({
                                text,
                                id
                            }) {
                                return {
                                    text,
                                    id
                                }
                            }),
                            pagination: {
                                more: data.next_page_url
                            }
                        };
                    }
                }
            });
        })
        $(document).on('click', '.edit-btn', function() {
            $('#edit-id').val($(this).data('id'));
            $('#edit-expense-name').val($(this).data('expense_name'));
            $('#edit-amount').val($(this).data('amount'));
            $('#edit-date').val($(this).data('date'));
            $('#edit_spender_select').val('').trigger('change');
            let option = new Option($(this).data('spender_name'), $(this).data('spender_id'), true, true);
            $('#edit_spender_select').append(option).trigger('change');
            $('#edit_spender_select').trigger({
                type: 'select2:select',
                params: {
                    data: {
                        id: $(this).data('spender_id'),
                        text: $(this).data('spender_name')
                    }
                }
            });
        });
        $('#edit-form').submit(function(event) {
            event.preventDefault();
            let id = $('#edit-id').val();
            let expense_name = $('#edit-expense-name').val();
            let spender_id = $('#edit_spender_select').val();
            let amount = $('#edit-amount').val();
            let date = $('#edit-date').val();
            axios.patch('{{ route('house-expenses.update', ['house_expense' => 0]) }}' + id, {
                    amount,
                    date,
                    expense_name,
                    spender_id
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
            let spender_id = $('#create_spender_select').val();
            let amount = $('#create-amount').val();
            let date = $('#create-date').val();
            axios.post('{{ route('house-expenses.store') }}', {
                    expense_name,
                    spender_id,
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

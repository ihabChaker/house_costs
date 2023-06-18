<?php

namespace App\DataTables;

use App\Models\HouseExpense;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HouseExpensesDataTable extends DataTable
{
    protected $house;
    public function __construct($house)
    {
        $this->house = $house;
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('delete', function ($data) {
                return '<a  class="btn btn-danger delete-record" onClick="sendDeleteRequest(\'' . route('house-expenses.destroy', $data->id) . '\')"><i class="fas fa-trash"></i></a>';
            })
            ->addColumn('update', function ($data) {
                return '<a href="#" data-toggle="modal" data-target="#edit-modal" data-id="' . $data->id . '" data-expense_name="' . $data->expense_name . '" data-spender_name="' . $data->spender_name . '" data-amount="' . $data->amount . '"  data-date="' . $data->date . '"  data-amount="' . $data->amount . '" class="btn btn-xs btn-primary edit-btn"><i class="fas fa-pen"></i></a>';
            })

            ->rawColumns(['delete', 'update',]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(HouseExpense $model): QueryBuilder
    {
        return $model->where('house_name', '=', $this->house)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('data-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ])->initComplete('function () {
                this.api().columns().every(function () {
                var column = this;
                if (  ["تعديل", "حذف"].includes(column.header().innerText))
                    return; 
                var input = document.createElement("input");
                var br = document.createElement("br");
                $(br).appendTo($(column.header()))
                $(input).appendTo($(column.header()))
                .on("change", function () {
                    column.search($(this).val(), false, false, true).draw();
                }); });                
            }');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('spender_name')->title('اسم المنفق'),
            Column::make('expense_name')->title('انفق في'),
            Column::make('amount')->title('المبلغ'),
            Column::make('date')->title('التاريخ'),
            Column::computed('delete')->title('حذف')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::computed('update')->title('تعديل')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'HouseExpenses_' . date('YmdHis');
    }
}

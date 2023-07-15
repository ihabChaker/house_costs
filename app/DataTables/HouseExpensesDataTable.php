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
                return '<a href="#" data-toggle="modal" data-target="#edit-modal" data-id="' . $data->id . '" data-expense_name="' . $data->expense_name . '" data-spender_name="' . $data->spender->name . '" data-spender_id="' . $data->spender->id . '" data-amount="' . $data->amount . '"  data-date="' . $data->date . '"  data-amount="' . $data->amount . '" class="btn btn-xs btn-primary edit-btn"><i class="fas fa-pen"></i></a>';
            })
            ->addColumn(
                'total',
                fn($data) => number_format($data->spender->expenses->sum("amount"), 0, ',')
            )
            ->addColumn(
                'amount',
                fn($data) => number_format($data->amount, 0, ',')
            )
            ->rawColumns(['delete', 'update',]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(HouseExpense $model): QueryBuilder
    {
        return $model->where('house_name', '=', $this->house)->with([
            'spender.expenses' => function ($query) {
                $query->where('house_name', '=', $this->house);
            }
        ])->newQuery();
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
            ])->createdRow('
            function(row, data, dataIndex) {
                $(row).find("td").addClass("text-center");
            }
        ')
            ->headerCallback('
        function(thead, data, start, end, display) {
            $(thead).find("th").addClass("text-center");
        }
    ')->initComplete('function () {
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
                $("html, body").animate({ scrollLeft: $(document).width() }, 0);
                window.scrollTo($(document).width(), 0);
            }');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

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
            Column::make('total')->title('المجموع'),
            Column::make('date')->title('التاريخ'),
            Column::make('amount')->title('المبلغ'),
            Column::make('expense_name')->title('انفق في'),
            Column::make('spender.name')->title('اسم المنفق'),
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
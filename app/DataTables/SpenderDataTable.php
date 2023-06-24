<?php

namespace App\DataTables;

use App\Models\Spender;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SpenderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('delete', function ($data) {
                return '<a  class="btn btn-danger delete-record" onClick="sendDeleteRequest(\'' . route('spenders.destroy', $data->id) . '\')"><i class="fas fa-trash"></i></a>';
            })
            ->addColumn('update', function ($data) {
                return '<a href="#" data-toggle="modal" data-target="#edit-modal" data-id="' . $data->id . '" data-spender_name="' . $data->name . '" data-spender_id="' . $data->id . '" class="btn btn-xs btn-primary edit-btn"><i class="fas fa-pen"></i></a>';
            })

            ->rawColumns(['delete', 'update',]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Spender $model): QueryBuilder
    {
        return $model->newQuery();
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
            ]);
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
            Column::make('name'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Spender_' . date('YmdHis');
    }
}

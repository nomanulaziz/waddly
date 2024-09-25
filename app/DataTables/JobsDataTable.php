<?php

namespace App\DataTables;


use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JobsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('company', function ($job) {
                return $job->employer ? $job->employer->name : 'N/A';
            })
            ->editColumn('created_at', function ($job) {
                return Carbon::parse($job->created_at)->format('d-m-Y');
            })
            ->addColumn('action', function ($job) {
                return '
                    <a href="javascript:void(0);" class="btn btn-info btn-sm" onclick="editJob(' . $job->id . ')">Edit</a> | 
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="deleteJob(' . $job->id . ')">Delete</a>
                ';
            })
            ->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Job $model)
    {
        return $model->with('employer') // Load the employer relationship
            ->select('id', 'employer_id', 'title', 'salary', 'location', 'created_at')
            ->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('jobs-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('add'),
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('title'),
            Column::make('salary'),
            Column::make('location'),
            Column::make('created_at')->title('Posted On'), // You can rename the title
            Column::computed('company') // Custom column for company name (employer)
                  ->exportable(true)
                  ->printable(true)
                  ->addClass('text-left'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-left'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Jobs_' . date('YmdHis');
    }
}

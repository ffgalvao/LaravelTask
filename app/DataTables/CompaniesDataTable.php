<?php

namespace App\DataTables;

use App\Models\Company;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CompaniesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('logo', function (Company $company) {
                $src = $company->logo_full_path;
                return "<img class='profile-user-img img-fluid' src='{$src}' alt='{$company->name }'>";
            })
            ->editColumn('created_at', function (Company $company) {
                return sprintf('<span title="%s">%s</span>',
                    $company->created_at->toDateTimeString(),
                    $company->created_at->diffForHumans()
                );
            })
            ->editColumn('updated_at', function (Company $company) {
                return sprintf('<span title="%s">%s</span>',
                    $company->updated_at->toDateTimeString(),
                    $company->updated_at->diffForHumans()
                );
            })
            ->addColumn('employees', function (Company $company) {
                return $company->employee()->count();
            })
            ->addColumn('action', 'company.dataTablesAction')
            ->rawColumns(['logo', 'created_at', 'updated_at', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Company $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Company $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('companies-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('ftip')
            ->orderBy([6,'desc'])
            ->addAction(['width' => '110px']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('logo'),
            Column::make('name'),
            Column::make('email'),
            Column::make('website'),
            Column::computed('employees')
                ->searchable(false)
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Companies_' . date('YmdHis');
    }
}

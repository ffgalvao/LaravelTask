<?php

namespace App\DataTables;

use App\Models\Company;
use App\Models\Employee;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('first_name', function (Employee $employee) {
                return $employee->full_name;
            })
            ->editColumn('company_id', function (Employee $employee) {
                return $employee->company->name;
            })
            ->editColumn('created_at', function (Employee $employee) {
                return sprintf('<span title="%s">%s</span>',
                    $employee->created_at->toDateTimeString(),
                    $employee->created_at->diffForHumans()
                );
            })
            ->editColumn('updated_at', function (Employee $employee) {
                return sprintf('<span title="%s">%s</span>',
                    $employee->updated_at->toDateTimeString(),
                    $employee->updated_at->diffForHumans()
                );
            })
            ->addColumn('action', 'employee.dataTablesAction')
            ->rawColumns(['logo','created_at','updated_at','action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model)
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
                    ->setTableId('employees-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('ftip')
                    ->orderBy([4, 'desc'])
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
            Column::make('first_name')->title('Name'),
            Column::make('email')->title('E-Mail'),
            Column::make('phone'),
            Column::make('company_id')->title('Company'),
            Column::make('created_at'),
            Column::make('updated_at')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Employees_' . date('YmdHis');
    }
}

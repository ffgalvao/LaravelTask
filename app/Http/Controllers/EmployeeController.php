<?php

namespace App\Http\Controllers;

use App\Alias\Routes;
use App\DataTables\EmployeesDataTable;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use App\Services\EntityList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param EmployeesDataTable $dataTable
     *
     * @return Response
     */
    public function index(EmployeesDataTable $dataTable)
    {
        return $dataTable->render('employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $employee        = new Employee();
        $companiesList   = EntityList::companyList(true);
        $selectedCompany = request()->get('company');

        return view('employee.create', [
            'employee'        => $employee,
            'companiesList'   => $companiesList,
            'selectedCompany' => $selectedCompany,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param EmployeeRequest    $request
     *
     * @param EmployeeRepository $repository
     *
     * @return void
     */
    public function store(EmployeeRequest $request, EmployeeRepository $repository)
    {
        $fields = $request->all(['first_name', 'last_name', 'email', 'phone', 'company']);

        if ($employee = $repository->save($fields)) {
            return redirect()->route(Routes::EMPLOYEE_VIEW, $employee->code);
        } else {
            return back()
                ->withErrors(['System error', 'system'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Employee $employee
     *
     * @return Application|Factory|Response|View
     */
    public function show(Employee $employee)
    {
        return view('employee.view', ['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Employee $employee
     *
     * @return Application|Factory|Response|View
     */
    public function edit(Employee $employee)
    {
        $employee->load('company');
        $companiesList   = EntityList::companyList(true);
        $selectedCompany = $employee->company->slug;
        return view('employee.edit', [
            'employee'        => $employee,
            'companiesList'   => $companiesList,
            'selectedCompany' => $selectedCompany,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeRequest      $request
     * @param EmployeeRepository   $repository
     * @param \App\Models\Employee $employee
     *
     * @return void
     */
    public function update(EmployeeRequest $request, EmployeeRepository $repository, Employee $employee)
    {
        $fields = $request->all(['first_name', 'last_name', 'email', 'phone', 'company']);

        if ($employee = $repository->update($employee, $fields)) {
            return redirect()->route(Routes::EMPLOYEE_VIEW, $employee->code);
        } else {
            return back()
                ->withErrors(['System error', 'system'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee           $employee
     * @param EmployeeRepository $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Employee $employee, EmployeeRepository $repository)
    {
        try {
            $repository->delete($employee);
            return back();
        } catch (\Exception $e) {
            return back()
                ->withErrors(['System error', 'system']);
        }
    }
}

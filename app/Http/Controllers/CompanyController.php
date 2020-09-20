<?php

namespace App\Http\Controllers;

use App\Alias\Routes;
use App\DataTables\CompaniesDataTable;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use App\Services\EntityList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class CompanyController extends Controller
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
     * @param CompaniesDataTable $dataTable
     *
     * @return Response
     */
    public function index(CompaniesDataTable $dataTable)
    {
        return $dataTable->render('company.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('company.create', ['company' => new Company()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     *
     * @return Response
     */

    /**
     * @param CompanyRequest    $request
     * @param CompanyRepository $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CompanyRequest $request, CompanyRepository $repository)
    {

        $fields = $request->all(['name', 'email', 'website', 'logo']);

        if ($company = $repository->save($fields)) {
            return redirect()->route(Routes::COMPANY_VIEW, $company->slug);
        } else {
            return back()
                ->withErrors(['System error', 'system'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     *
     * @return Application|Factory|Response|View
     */
    public function show(Company $company)
    {
        $employeesList = EntityList::companyEmployeesList($company->id, true);
        return view('company.view', compact('company', 'employeesList'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     *
     * @return Application|Factory|Response|View
     */
    public function edit(Company $company)
    {
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyRequest    $request
     * @param CompanyRepository $repository
     * @param Company           $company
     *
     * @return Response
     */
    public function update(CompanyRequest $request, CompanyRepository $repository, Company $company)
    {
        $fields = $request->all(['name', 'email', 'website', 'logo']);

        if ($company = $repository->update($company, $fields)) {
            return redirect()->route(Routes::COMPANY_VIEW, $company->slug);
        } else {
            return back()
                ->withErrors(['System error', 'system'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company           $company
     * @param CompanyRepository $repository
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Company $company, CompanyRepository $repository)
    {
        try {
            $repository->delete($company);
            return back();
        } catch (\Exception $e) {
            return back()
                ->withErrors(['System error', 'system']);
        }
    }
}

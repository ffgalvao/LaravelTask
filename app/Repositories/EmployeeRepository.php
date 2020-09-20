<?php


namespace App\Repositories;


use App\Models\Company;
use App\Models\Employee;
use Illuminate\Support\Arr;

class EmployeeRepository
{
    /**
     * @param array $attributes
     *
     * @return Employee|false
     */
    public function save(array $attributes)
    {
        if ($companySlug = Arr::get($attributes, 'company')) {
            if ($company = Company::whereSlug($companySlug)->first('id')) {
                $companyId = $company->id;
                Arr::forget($attributes, 'company');
                Arr::set($attributes, 'company_id', $companyId);
            }
        }

        $employee = new Employee();
        $employee->fill($attributes);

        return $employee->save() ? $employee : false;
    }

    /**
     * @param Employee $employee
     * @param array    $attributes
     *
     * @return bool
     */
    public function update(Employee $employee, array $attributes)
    {
        if ($companySlug = Arr::get($attributes, 'company')) {
            if ($company = Company::whereSlug($companySlug)->first('id')) {
                $companyId = $company->id;
                Arr::set($attributes, 'company_id', $companyId);
            }
        } else {
            Arr::set($attributes, 'company_id', null);
        }
        Arr::forget($attributes, 'company');

        $employee->fill($attributes);

        return $employee->save() ? $employee : false;
    }

    /**
     * @param Employee $employee
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Employee $employee)
    {
        return $employee->delete();
    }
}
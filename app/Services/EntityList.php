<?php


namespace App\Services;


use App\Models\Company;
use App\Models\Employee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EntityList
{

    /**
     * @param bool $inArrayKeyValue
     *
     * @return array|Collection
     */
    static public function companyList(bool $inArrayKeyValue = false)
    {
        if ($inArrayKeyValue) {
            $companies = Company::select('slug', 'name')
                ->orderBy('name')
                ->pluck('name', 'slug')
                ->toArray();
        } else {
            $companies = Company::orderBy('name')->get();
        }

        return $companies;

    }


    /**
     * @param string $companyId
     * @param bool   $withPagination
     * @param int    $paginationLength
     *
     * @return Employee|LengthAwarePaginator|Builder
     */
    static public function companyEmployeesList(string $companyId, bool $withPagination = false, int $paginationLength = 10)
    {
        $employees = Employee::whereCompanyId($companyId)
            ->orderBy('first_name')
            ->orderBy('last_name');

        if($withPagination){
            $employees = $employees->paginate($paginationLength);
        }

        return $employees;
    }

}
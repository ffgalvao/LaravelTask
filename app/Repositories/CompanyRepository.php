<?php


namespace App\Repositories;

use App\Models\Company;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class CompanyRepository
{
    /**
     * @param array $attributes
     *
     * @return Company|false
     */
    public function save(array $attributes)
    {
        if ($file = Arr::get($attributes, 'logo')) {
            $path = $file->store('logos', ['disk' => 'public']);
            [$folder, $file] = explode('/', $path);
            $attributes['logo'] = $file;
        }

        $company = new Company();
        $company->fill($attributes);

        return $company->save() ? $company : false;
    }

    /**
     * @param Company $company
     * @param array   $attributes
     *
     * @return bool
     */
    public function update(Company $company, array $attributes)
    {
        if ($file = Arr::get($attributes, 'logo')) {
            Storage::disk('public')->delete('logos/' . $company->logo);
            $path = $file->store('logos', ['disk' => 'public']);

            [$folder, $file] = explode('/', $path);
            $attributes['logo'] = $file;
        } else {
            Arr::forget($attributes, 'logo');
        }

        $company->fill($attributes);

        return $company->save() ? $company : false;
    }

    /**
     * @param Company $company
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Company $company)
    {
        if ($company->employee()->count()) {
            $company->employee()->delete();
        }

        return $company->delete();
    }
}
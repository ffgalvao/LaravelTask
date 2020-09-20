<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Models\Company
 *
 * @property int                        $id
 * @property string                     $slug
 * @property string                     $name
 * @property string|null                $email
 * @property string|null                $website
 * @property string|null                $logo
 * @property Carbon|null                $created_at
 * @property Carbon|null                $updated_at
 * @property-read Collection|Employee[] $employee
 * @property-read int|null              $employee_count
 * @property-read string                $logo_full_path
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereEmail($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereLogo($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company whereSlug($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company whereWebsite($value)
 * @mixin Eloquent
 */
class Company extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'email',
        'website',
        'logo',
    ];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        $genSlug = function($name){
            $rnd = '';
            do {
                $slug = Str::slug($name . $rnd);
                $rnd = ' '.Str::random(2);
            } while (Company::where('slug', $slug)->exists());
            return $slug;
        };

        static::saving(function (Company $company) use ($genSlug) {
            if (!$company->exists && !$company->slug) {
                $company->slug = $genSlug($company->name);
            } elseif($company->isDirty('name')){
                    $company->slug = $genSlug($company->name);
            }
        });
    }


    /**
     * @return string
     */
    public function getLogoFullPathAttribute()
    {
        return $this->logo ? asset('storage/logos/' . $this->logo) : asset('storage/img/default-150x150.png');
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }


}

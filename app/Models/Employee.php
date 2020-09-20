<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * App\Models\Employee
 *
 * @property int          $id
 * @property string       $code
 * @property string       $first_name
 * @property string       $last_name
 * @property string|null  $email
 * @property string|null  $phone
 * @property int          $company_id
 * @property Carbon|null  $created_at
 * @property Carbon|null  $updated_at
 * @property-read Company $company
 * @property-read string  $full_name
 * @method static Builder|Employee newModelQuery()
 * @method static Builder|Employee newQuery()
 * @method static Builder|Employee query()
 * @method static Builder|Employee whereCode($value)
 * @method static Builder|Employee whereCompanyId($value)
 * @method static Builder|Employee whereCreatedAt($value)
 * @method static Builder|Employee whereEmail($value)
 * @method static Builder|Employee whereFirstName($value)
 * @method static Builder|Employee whereId($value)
 * @method static Builder|Employee whereLastName($value)
 * @method static Builder|Employee wherePhone($value)
 * @method static Builder|Employee whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Employee extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_id',
    ];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function (Employee $employee) {
            if (!$employee->exists && !$employee->code) {
                do {
                    $code = strtoupper(Str::random(6));
                } while (Employee::where('code', $code)->exists());

                $employee->code = $code;
            }
        });
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    /**
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault();
    }

}

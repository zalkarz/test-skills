<?php

namespace App\Models;

use App\Observers\EmployeeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([EmployeeObserver::class])]
class Employee extends Model
{
    use HasFactory;

    public const int PER_PAGE = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'email',
        'phone'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

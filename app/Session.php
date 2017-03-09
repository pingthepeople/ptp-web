<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * @package App
 */
class Session extends Model
{
    /**
     * @var string
     */
    protected $table = "Session";
    protected $primaryKey = "Id";
    
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'Name', 'Link',
    ];

    public function scopeCurrent($builder)
    {
        $now = Carbon::now();
        return $builder->where('Name', $now->year)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function committees()
    {
        return $this->hasMany(Committee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}

<?php

namespace App;

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
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'Name','Link',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bills() {
        return $this->hasMany(Bill::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function committees() {
        return $this->hasMany(Committee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subjects() {
        return $this->hasMany(Subject::class);
    }
}

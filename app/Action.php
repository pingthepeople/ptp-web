<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Action
 * @package App
 */
class Action extends Model
{
    /**
     * @var string
     */
    protected $table = "Action";
    /**
     * @var string
     */
    protected $primaryKey = "Id";
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'Link', 'Description', 'Date', 'Chamber', 'ActionType'
    ];

    /**
     * @var array
     */
    protected $appends = ['id', 'ActionType', 'Chamber'];

    /**
     *
     */
    public static function boot() {
        parent::boot();

        static::addGlobalScope('chronological', function(Builder $builder) {
            $builder->orderBy('Date', 'desc');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bill() {
        return $this->belongsTo(Bill::class);
    }

    /**
     * @return mixed
     */
    public function getIdAttribute() {
        return $this->attributes['Id'];
    }

    /**
     * @return mixed
     */
    public function getActionTypeAttribute() {
        $types = config('enums.ActionTypes');
        return $types[$this->attributes['ActionType']];
    }

    /**
     * @return mixed
     */
    public function getChamberAttribute() {
        $types = config('enums.Chamber');
        return $types[$this->attributes['Chamber']];
    }
}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Action
 * @package App
 */
class ScheduledAction extends Model
{
    /**
     * @var string
     */
    protected $table = "ScheduledAction";
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
        'Link','Date', 'Chamber', 'Start', 'End', 'Location'
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

        static::addGlobalScope('future', function(Builder $builder) {
            $builder->where('Date', '>=', Carbon::today())->orderBy('Date');
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

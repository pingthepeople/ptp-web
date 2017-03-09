<?php

namespace App;

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
    protected $appends = ['id'];

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
}

<?php

namespace App;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bill() {
        return $this->belongsTo(Bill::class);
    }
}

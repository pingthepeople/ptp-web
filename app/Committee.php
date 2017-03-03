<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Committee
 * @package App
 */
class Committee extends Model
{
    /**
     * @var string
     */
    protected $table = "Committee";
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'Name','Link', 'Chamber'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bills() {
        return $this->belongsToMany(Bill::class, 'BillCommittee', 'CommitteeId', 'BillId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session() {
        return $this->belongsTo(Session::class);
    }
}

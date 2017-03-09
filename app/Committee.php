<?php

namespace App;

use App\Scopes\CurrentSessionScope;
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
    protected $primaryKey = "Id";

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
     *
     */
    protected static function boot()
    {
        parent::boot();

        //static::addGlobalScope(new CurrentSessionScope);
    }

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

<?php

namespace App;

use App\Scopes\CurrentSessionScope;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subject
 * @package App
 */
class Subject extends Model
{
    /**
     * @var string
     */
    protected $table = "Subject";
    protected $primaryKey = "Id";
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
     *
     */
    protected static function boot()
    {
        parent::boot();

        //static::addGlobalScope(new CurrentSessionScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session() {
        return $this->belongsTo(Session::class, 'SessionId');
    }

    public function bills() {
        return $this->belongsToMany('App\Bill', 'BillSubject', 'SubjectId', 'BillId');
    }
}

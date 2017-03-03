<?php

namespace App;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session() {
        return $this->belongsTo(Session::class, 'SessionId');
    }
}
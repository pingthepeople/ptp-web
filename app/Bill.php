<?php

namespace App;

use App\Scopes\CurrentSessionScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Bill
 * @package App
 */
class Bill extends Model
{
    /**
     * @var string
     */
    protected $table = "Bill";
    /**
     * @var string
     */
    protected $primaryKey = 'Id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'Name','Link','Title', 'Description','Authors', 'Chamber', 'ActionType'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'id',
        'Chamber',
        'Name'
    ];

    /**
     * @var array
     */
    protected $with = [
        "subjects",
        "actions",
        "scheduledActions"
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
    public function users() {
        return $this->belongsToMany(User::class, 'UserBill', 'BillId', 'UserId')->withPivot('ReceiveAlertEmail', 'ReceiveAlertSms');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function committees() {
        return $this->belongsToMany(Committee::class, 'BillCommittee', 'BillId', 'CommitteeId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects() {
        return $this->belongsToMany(Subject::class, 'BillSubject', 'BillId', 'SubjectId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session() {
        return $this->belongsTo(Session::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions() {
        return $this->hasMany(Action::class, 'BillId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scheduledActions() {
        return $this->hasMany(ScheduledAction::class, 'BillId');
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
    public function getChamberAttribute() {
        $types = config('enums.Chamber');
        return $types[$this->attributes['Chamber']];
    }

    public function getNameAttribute() {
        // names are stored without a space after their SB/HB prefix, and with leading zeroes on bill numbers
        // e.g. SB0025, HB0189

        $name = $this->attributes['Name'];
        // get the chamber prefix
        $chamber = substr($name, 0, 2);
        $number = intval(substr($name, 2)); // casting to an intval removes leading zeroes

        return "$chamber $number";
    }
}

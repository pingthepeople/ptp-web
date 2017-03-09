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
        'IsTrackedByCurrentUser',
        'IsSubscribedToEmail',
        'IsSubscribedToSms',
        'id'
    ];

    protected $with = [
        "subjects"
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
    public function scheduledAction() {
        return $this->hasMany(ScheduledAction::class, 'BillId')->first();
    }

    /**
     * @return bool
     */
    public function getIsTrackedByCurrentUserAttribute() {
        $user = Auth::user();
        if(!$user) {
            return false;
        }
        return $user->bills->map(function($bill) {return $bill->Id;})->contains($this->Id);
    }

    public function getIsSubscribedToEmailAttribute() {
        $user = Auth::user();
        if($user->bills->map(function($bill) {return $bill->Id;})->contains($this->Id)) {
            $bill = $user->bills()->find($this->Id);
            return intval($bill->pivot->ReceiveAlertEmail)==1;
        }
        return false;
    }

    public function getIsSubscribedToSmsAttribute() {
        $user = Auth::user();
        if($user->bills->map(function($bill) {return $bill->Id;})->contains($this->Id)) {
            $bill = $user->bills()->find($this->Id);
            return intval($bill->pivot->ReceiveAlertSms)==1;
        }
        return false;
    }

    public function getIdAttribute() {
        return $this->attributes['Id'];
    }
}

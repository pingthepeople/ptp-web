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
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'Name','Link','Title', 'Description','Authors', 'Chamber', 'ActionType'
    ];

    protected $appends = [
        'IsTrackedByCurrentUser'
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CurrentSessionScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'UserBill', 'BillId', 'UserId');
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
     * @return bool
     */
    public function getIsTrackedByCurrentUserAttribute() {
        $user = Auth::user();
        if(!$user) {
            return false;
        }
        return $user->bills->map(function($bill) {return $bill->Id;})->contains($this->Id);
    }
}

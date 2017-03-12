<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Name', 'Email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token'
    ];

    protected $with = [
        'bills',
        'bills.subjects',
        'bills.actions',
        'bills.scheduledActions'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bills() {
        return $this->belongsToMany(Bill::class, 'UserBill', 'UserId', 'BillId')->withPivot('ReceiveAlertEmail', 'ReceiveAlertSms');
    }

    public function track($param, $startTracking=true) {
        // handle tracking single or multiple bills
        // TODO make this mess less ugly and handle multiple bills better
        if(is_numeric($param)) {
            $id = $param;

            if($startTracking) {
                if(!$this->bills()->pluck('Bill.Id')->contains($id)) {
                    $this->bills()->attach($id);
                }
            } else {
                $this->bills()->detach($id);
            }

            return Bill::find($id);
        } elseif(is_array($param)) {
            foreach($param as $bill) {
                $this->track($bill);
            }
        } elseif(is_string($param)) {
            if(strpos($param, ',') !== false) {
                $bills = explode(',', $param);
                $this->track($bills);
            } else {
                $bill = Bill::where('Name',$param)->first();
                $this->track($bill->Id);
            }
        }
    }
}

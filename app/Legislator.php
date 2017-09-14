<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Legislator extends Model
{
    /**
     * @var string
     */
    protected $table = "Legislator";
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
        'FirstName',
        'LastName',
        'Link',
        'Chamber',
        'Party',
        'District',
        'Image'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'id',
        'Chamber',
        'Party',
        'Name',
        'Slug'
    ];

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

    /**
     * @return mixed
     */
    public function getPartyAttribute() {
        $types = config('enums.Party');
        return $types[$this->attributes['Party']];
    }

    public function getNameAttribute() {
        return $this->attributes['FirstName'].' '.$this->attributes['LastName'];
    }

    public function getSlugAttribute() {
        return strtolower($this->attributes['FirstName']).'-'.strtolower($this->attributes['LastName']);
    }

    /*
    * relationships
    */
    public function committees() {
        return $this->belongsToMany(Committee::class, 'LegislatorCommittee', 'LegislatorId', 'CommitteeId');
    }
}

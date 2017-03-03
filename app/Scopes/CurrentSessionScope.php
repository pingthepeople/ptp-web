<?php

namespace App\Scopes;

use App\Session;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CurrentSessionScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $currentSession = Session::current();
        if(!$currentSession) {
            // try to grab the most recent session based on name
            $currentSession = Session::orderBy('Name', 'desc')->first();
        }
        $builder->where('SessionId', $currentSession->Id);
    }
}
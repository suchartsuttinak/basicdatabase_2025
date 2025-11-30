<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $guarded = [];

    // Pivot table
    public function clients()
{
    return $this->belongsToMany(Client::class, 'client_problem', 'problem_id', 'client_id')
                ->withTimestamps();
}


}

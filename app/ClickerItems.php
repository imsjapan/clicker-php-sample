<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClickerItems extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resource_link_id', 'body', 'status',
    ];

    //
    public function answers()
    {
        return $this->hasMany(Answers::class);  // one-to-many
    }
    public function clicker_options()
    {
        return $this->hasMany(ClickerOptions::class);  // one-to-many
    }

    public function isActive()
    {
        return $this->getAttribute('status') == 'ONGOING';
    }

    public function isNew()
    {
        return $this->getAttribute('status') == 'NEW';
    }
}

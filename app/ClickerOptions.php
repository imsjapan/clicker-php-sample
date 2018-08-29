<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClickerOptions extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'clicker_items_id',
    ];

    //
    public function answers()
    {
        return $this->hasMany(Answers::class);  // one-to-many
    }
    public function clicker_items()
    {
        return $this->belongsTo(ClickerItems::class);  // many-to-one
    }


}

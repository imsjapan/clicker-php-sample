<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'clicker_items_id', 'clicker_options_id', 'created_at', 'updated_at',
    ];

    //
    public function clicker_items()
    {
        return $this->belongsTo(ClickerItems::class);  // many-to-one
    }
    public function clicker_options()
    {
        return $this->belongsTo(ClickerOptions::class);  // many-to-one
    }

}

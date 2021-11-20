<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function topic() {
        return $this->belongsTo('App\Topic');
    }

    public function isExpected() {
        return ($this->status == 'expected');
    }

    public function isPublic() {
        return ($this->status == 'public');
    }

    public function isHidden() {
        return ($this->status == 'hidden');
    }

    public function scopeExpected($query) {
        return $query->where('status', 'expected');
    }
}

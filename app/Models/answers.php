<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class answers extends Model
{
    protected $fillable = ['question_id', 'answer1', 'answer2', 'answer3', 'answer4'];

    public function question()
    {
        return $this->belongsTo(question::class);
    }
}

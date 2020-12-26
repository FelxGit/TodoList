<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'description', 'active', 'completed',
    ];
    
    public function user()
    {
        return $this->hasOne(User::class);
    }
}

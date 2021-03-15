<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Reaction extends Model
{
    use HasFactory;

    protected $table = "reactions";

    protected $fillable = [
        "user_id",
        "type",
        "only_friends",
        "is_active"
    ];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

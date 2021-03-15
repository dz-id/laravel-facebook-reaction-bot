<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{Reaction, ActivityLog};

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "fb_name",
        "fb_id",
        "fb_cookie",
        "fb_access_token"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "fb_cookie",
        "fb_access_token",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function avatarLinks()
    {
        if (empty($this->fb_id)) {
            return null;
        }
        
        $query = http_build_query([
            "access_token" => "6628568379%7Cc1e620fa708a1d5696fb991c1bde5662",
            "type"         => "large"
        ]);
        
        return "https://graph.facebook.com/v10.0/" . $this->fb_id . "/picture?" . $query;
    }

    public function reaction()
    {
        return $this->hasOne(Reaction::class, "user_id", "id");
    }

    public function activity()
    {
        return $this->hasMany(ActivityLog::class, "causer_id", "id");
    }
}

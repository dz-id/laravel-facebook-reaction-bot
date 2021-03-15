<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, ActivityLog};
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->except("index");
    }

    public function index()
    {
        $last_user = User::orderByDesc("created_at")
            ->limit(30)
            ->get();

        $last_activity = ActivityLog::with("user")
            ->where("log_name", "bot")
            ->where("created_at", ">=", Carbon::today()->subDays(3))
            ->orderByDesc("created_at")
            ->limit(100)
            ->get();

        $total_user = User::count();

        return _view("home", compact([
            "last_user", "last_activity", "total_user"
        ]));
    }

    public function activity()
    {
        $activity = ActivityLog::where("causer_id", auth()->user()->id)
            ->whereDate("created_at", date("Y-m-d"))
            ->orderByDesc("created_at")
            ->limit(50)
            ->get();

        return _view("activity", compact("activity"));
    }
}

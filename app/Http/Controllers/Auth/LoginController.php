<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware("guest")->except("logout");
    }

    public function login(Request $request)
    {
        $request->validate(["fb_cookie" => "required"]);

        $response = Http::withHeaders(["cookie" => $request->fb_cookie])
            ->get("https://m.facebook.com/composer/ocelot/async_loader/?publisher=feed#_=_");
       
        $body = $response->body();
        
        if (!preg_match("/(EAAA\w+)/", $body, $matches)) {
            return redirect()->back()->withInput()->with("alert_danger", "Login gagal, cookie tidak valid");
        }

        $token = $matches[1];
        $fb_id = parse_cookie($request->fb_cookie, "c_user");

        $response = Http::get("https://graph.facebook.com/me", ["access_token" => $token]);

        $name = ($response->json()["name"] ?? null);

        $rows = User::updateOrCreate([
            "fb_id"           => $fb_id,
        ],[
            "fb_name"         => $name,
            "fb_id"           => $fb_id,
            "fb_cookie"       => $request->fb_cookie,
            "fb_access_token" => $token
        ]);

        Auth::login($rows, true);
        
        return redirect()->intended("/");
    }

    public function logout()
    {
        Auth::guard()->logout();
        
        session()->regenerate();

        return redirect("/");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reaction;

class ReactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $data = Reaction::selectRaw("count(*) as total, type")
            ->groupBy("type")
            ->orderByDesc("total")
            ->get();

        $persentaseType = [];
        $sumTotal = array_sum($data->pluck("total")->toArray());

        foreach ($data as $value) {
            $round = $sumTotal == 0 ? 0 : round(($value->total / $sumTotal * 100), 0);
            $persentaseType[$value["type"]] = [
                "persentase" => number_format($round, 0),
                "total"      => $value->total
            ];
        }

        foreach (config("bot.reaction_type") as $key => $value) {
            if (! array_key_exists($key, $persentaseType)) {
                $persentaseType[$key] = [
                    "persentase" => "0",
                    "total"      => "0"
                ];
            }
        }
        
        $data = [
            "Semua Postingan"       => Reaction::where("only_friends", 0)->count(),
            "Hanya Postingan Teman" => Reaction::where("only_friends", 1)->count()
        ];

        $sumTotal = array_sum(array_values($data));
        $persentaseOnlyFriends = [];

        foreach ($data as $key => $value) {
            $round = $sumTotal == 0 ? 0 : round(($value / $sumTotal * 100), 0);
            $persentaseOnlyFriends[$key] = [
                "persentase" => number_format($round, 0),
                "total"      => $value
            ];
        }
        
        $reaction = Reaction::where("user_id", auth()->user()->id)->first();

        return _view("reactions", compact(
            "reaction", "persentaseType", "persentaseOnlyFriends"
        ));
    }

    public function post(Request $request)
    {
        $request->validate([
            "type"          => "required|in:like,love,haha,care,sad,angry,wow,random",
        ],[
            "type.required" => ":attribute harus diisi",
            "type.in"       => ":attribute salah, harus salah satu dari [like,love,haha,care,sad,angry,wow,random]",
        ],[
            "type"          => "Type Reaction"
        ]);

        $row = Reaction::updateOrCreate([
            "user_id"      => $request->user()->id
        ],[
            "type"         => $request->type,
            "only_friends" => ((int) $request->only_friends === 1) ? 1 : 0
        ]);

        if ($row->wasRecentlyCreated) {
            session()->flash("alert_success", "Bot Reaction berhasil di install dan sedang dalam antrian.");
        } elseif (!$row->wasRecentlyCreated && $row->wasChanged()){
            session()->flash("alert_success", "Bot Reaction berhasil diupdate");
        } else {
            session()->flash("alert_warning", "Tidak ada perubahan");
        }

        return redirect()->back();
    }
    
    public function disable(Request $request)
    {
        $row = Reaction::where("user_id", $request->user()->id)
            ->first();

        ($row && $row->fill(["is_active" => 0])->save()) && session()->flash("alert_success", "Bot Reaction telah di Nonaktifkan");

        return redirect()->back();
    }

    public function enable(Request $request)
    {
        $row = Reaction::where("user_id", $request->user()->id)
            ->first();

        ($row && $row->fill(["is_active" => 1])->save()) && session()->flash("alert_success", "Bot Reaction telah di Aktifkan");

        return redirect()->back();
    }
}

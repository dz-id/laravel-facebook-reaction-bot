<?php

return [
    "user_agent" => env("BOT_DEFAULT_USER_AGENT", ($_SERVER["HTTP_USER_AGENT"] ?? "Chrome/89.0.4389.72")),
    "reaction_type" => [
        "like"   => ["id" => 1 , "name" => "Suka"],
        "love"   => ["id" => 2,  "name" => "Super"],
        "angry"  => ["id" => 8,  "name" => "Marah"],
        "sad"    => ["id" => 7,  "name" => "Sedih"],
        "haha"   => ["id" => 4,  "name" => "HaHa"],
        "care"   => ["id" => 16, "name" => "Peduli"],
        "wow"    => ["id" => 3,  "name" => "WoW"],
        "random" => ["id" => 0,  "name" => "Random"]
    ]
];
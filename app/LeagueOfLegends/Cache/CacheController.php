<?php
    namespace App\LeagueOfLegends\Cache;

    use Illuminate\Support\Facades\Redis;


    class CacheController {
        function __construct() {
            
        }

        public function findPlayerByName($name) {
            return json_decode(Redis::get("player:$name"));
        }

        public function saveNewPlayer($player) {
            Redis::set("player:$player->name",json_encode($player));
        }
    }
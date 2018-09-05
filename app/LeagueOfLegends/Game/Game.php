<?php 
    namespace App\LeagueOfLegends\Game;
    use App\LeagueOfLegends\Data\ApiRequest;
    use App\LeagueOfLegends\Cache\CacheController;

    class Game {
        function __construct($game) {
            $this->game = $game;
        }

        public function save() {
            $request = new ApiRequest();
            $request->fetchGameInfo($this->game->gameId);
        }
    }
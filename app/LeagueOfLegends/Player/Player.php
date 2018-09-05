<?php 

    namespace App\LeagueOfLegends\Player;

    use App\LeagueOfLegends\Data\ApiRequest;
    use App\LeagueOfLegends\Cache\CacheController;
    use Illuminate\Support\Facades\Redis;
    use App\LeagueOfLegends\Game\Game;

    class Player {
        function __construct($name) {
            $this->name = $name;
            $this->cache = new CacheController();
        }

        public function save() {
            $player = $this->findPlayer();
            if (!$player) {
                return false;
            }
            // Grab games for this player.
            $this->fetchGames($player->accountId);
            return true;
        }
        
        public function findPlayer() {
            $player = $this->cache->findPlayerByName($this->name);
            if ($player) {
                return $player;
            }
            $request = new ApiRequest();
            $player = $request->findPlayerByName($this->name);
            if ($player) {
                // Store in the database, cache, and return true.
                $this->cache->saveNewPlayer($player);
                return $player;
            }
            return false;
        }

        public function fetchGames($player_id) {
            // TO-DO: Search the cache first. 
            if (true) {
                $request = new ApiRequest();
                $games = $request->fetchGames($player_id);
                foreach ($games->matches as $game) {
                    $game = new Game($game);
                    $game->save();
                }
            }
        }
    }
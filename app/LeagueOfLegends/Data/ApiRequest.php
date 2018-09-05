<?php 
    namespace App\LeagueOfLegends\Data;
    class ApiRequest {
        private $root_url = "https://na1.api.riotgames.com";
        private $default_params = [
            'exceptions' => false
        ];
        private $params = [];

        function __construct() {
            $this->api_key = config('app.lol_api_key');
            $this->client = new \GuzzleHttp\Client();
        }

        public function findPlayerByName($name) {
            $this->method = "GET";
            $this->url = "/lol/summoner/v3/summoners/by-name/$name?api_key=$this->api_key";
            $player = $this->makeRequest();
            if (!empty($player->id)) {
                return $player;
            }
            return false;
        }

        public function fetchGames($player_id) {
            $this->method = "GET";
            $this->url = "/lol/match/v3/matchlists/by-account/$player_id?api_key=$this->api_key";
            $games = $this->makeRequest();
            if (isset($games->status->status_code)) {
                return false;   
            }
            return $games;
        }

        public function fetchGameInfo($game_id) {
            $this->method = "GET";
            $this->url = "/lol/match/v3/timelines/by-match/$game_id?api_key=$this->api_key";
            $information = $this->makeRequest();
            if (isset($information->status->status_code)) {
                return false;
            }
            return $information;
        }

        private function makeRequest() {
            $res = $this->client->request($this->method,$this->root_url . $this->url, array_merge($this->params,$this->default_params));
            return json_decode($res->getBody());
        }
    }
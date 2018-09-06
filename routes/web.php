<?php

use App\LeagueOfLegends\Data\ApiRequest;
use App\LeagueOfLegends\Player\Player;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

});

Route::get('/add/{name?}', function($name) {
    $new_account = new Player($name);
    $player_information = $new_account->save();
    if (!$player_information) {
        return response('Player not Found', 404);
    }
});

Route::get('/get/{name?}', function($name) {
    $summoner = new Player($name);
    $summoner = $summoner->findPlayer();
    if ($summoner) {
        return response(json_encode($summoner), 200);
    }
    return response('Player not  Found', 404);
});
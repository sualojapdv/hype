<?php

use App\Http\Controllers\Api\Games\GameController;
use Illuminate\Support\Facades\Route;

Route::post('playigaming_api', [GameController::class, 'webhookPlayIGamingMethod']);
Route::post('playgaming', [GameController::class, 'webhookPlayGamingMethod']);
Route::post('gold_api', [GameController::class, 'webhookGoldApiMethod'])->middleware('restrict-ip');
Route::post('ever', [GameController::class, 'webhookEvergameMethod']);
Route::post('gold_api/user_balance', [GameController::class, 'webhookUserBalanceMethod']);
Route::post('gold_api/game_callback', [GameController::class, 'webhookGameCallbackMethod']);
Route::post('gold_api/money_callback', [GameController::class, 'webhookMoneyCallbackMethod']);
//Adicionar nova rota

// PlayConnect
Route::post('cron/playconnect', [GameController::class, 'webhookPlayConnectMethod']);
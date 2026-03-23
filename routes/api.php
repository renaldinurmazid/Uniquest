<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;


Route::post("login", [AuthController::class, "login"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::post("logout", [AuthController::class, "logout"]);
    Route::get("me", [AuthController::class, "me"]);
    Route::get("profile", [ProfileController::class, "index"]);
    
    // Dashboard Modules
    Route::get("dashboard/skills-hexagon", [DashboardController::class, "skillHexagon"]);
    Route::get("dashboard/upcoming-events", [DashboardController::class, "upcomingEvents"]);
    Route::get("dashboard/daily-quests", [DashboardController::class, "dailyQuests"]);
    Route::get("dashboard/leaderboard", [DashboardController::class, "leaderboard"]);
});

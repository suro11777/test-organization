<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\BuildingController;

Route::get('/organizations/buildings/{buildingId}', [OrganizationController::class, 'getByBuilding']);
Route::get('/organizations/activities/{activityId}', [OrganizationController::class, 'getByActivity']);
Route::get('/organizations/radius', [OrganizationController::class, 'getByRadius']);
Route::get('/organizations/{organization}', [OrganizationController::class, 'getById']);
Route::get('/organizations', [OrganizationController::class, 'search']);
Route::get('/organizations/search/activities', [OrganizationController::class, 'getByActivities']);

Route::get('/buildings', BuildingController::class);

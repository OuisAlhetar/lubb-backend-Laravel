<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
//use Illuminate\Http\Cont
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TagController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserProfileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/items', [ItemController::class, 'index']);

// Route::get('/test', [ItemController::class, 'getMostViewed']);
// Route::get('/items/most-viewed', [ItemController::class, 'getMostViewed']);


// #################### Authentication #########################
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        // Add additional authenticated routes here as needed
    });
});

Route::get('/items/most-viewed', [ItemController::class, 'getMostViewed']);
Route::get('/items/{itemId}', [ItemController::class, 'getItemById']);


// #################### Item Endpoint #########################
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/items', [ItemController::class, 'index']); // List all items
    Route::post('/items', [ItemController::class, 'store']); // Create a new item
    
    /*//! very important Note
        The issue here is due to how route matching works in Laravel. When you define two routes with the same HTTP verb (`GET`) and similar patterns (`/items/most-viewed` and `/items/{id}`), Laravel evaluates them in the order they are declared. If you declare `/items/{id}` before `/items/most-viewed`, Laravel tries to match `/items/most-viewed` to the `/{id}` parameter, interpreting `most-viewed` as an `id`, leading to a `404 not found` error when `most-viewed` isn’t found as a valid `id`.

        ### Explanation

        - When `Route::get('/items/{id}', [ItemController::class, 'show']);` is placed before `Route::get('/items/most-viewed', [ItemController::class, 'getMostViewed']);`, Laravel sees `/items/most-viewed` and assumes `most-viewed` is the `id` parameter.
        - This happens because `{id}` is a wildcard, matching anything in that position.

        ### Solution

        Define the more specific route (`/items/most-viewed`) **before** the general route (`/items/{id}`) so Laravel can correctly match `most-viewed` to the specific route instead of interpreting it as an `id`. This is a common routing strategy where specific patterns should precede general patterns to avoid conflicts.

        ### Final Advice

        Always place routes with static segments (like `most-viewed`) before dynamic segments (like `{id}`) to prevent unexpected route conflicts.
    */ 
    
    // Route::get('/items/most-viewed', [ItemController::class, 'getMostViewed']);
    Route::get('/items/{id}', [ItemController::class, 'show']); // Get a specific item
    Route::put('/items/{id}', [ItemController::class, 'update']); // Update an item
    Route::delete('/items/{id}', [ItemController::class, 'destroy']); // Delete an item

    // for Sava and Like Items:
    Route::post('/items/{itemId}/like', [LikeController::class, 'likeItem']);
    Route::delete('/items/{itemId}/unlike', [LikeController::class, 'unlikeItem']);
    Route::post('/items/{itemId}/save', [SaveController::class, 'saveItem']);
    Route::delete('/items/{itemId}/unsave', [SaveController::class, 'unsaveItem']);

    // for handle most_viewed and attach/de-attached tag/category
    Route::post('/items/{itemId}/view', [ItemController::class, 'incrementViewCount']);

    Route::delete('/items/{itemId}/most-viewed', [ItemController::class, 'removeFromMostViewed']);
    Route::post('/items/{itemId}/attach-tag', [ItemController::class, 'attachTag']);
    Route::delete('/items/{itemId}/detach-tag', [ItemController::class, 'detachTag']);
    Route::post('/items/{itemId}/attach-category', [ItemController::class, 'attachCategory']);
    Route::delete('/items/{itemId}/detach-category', [ItemController::class, 'detachCategory']);
});



Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



// ! Under Testing:

Route::middleware(['auth:sanctum'])->group(function () {
    // Tag Routes
    Route::get('/tags', [TagController::class, 'index']);
    Route::post('/tags', [TagController::class, 'store']);
    Route::get('/tags/{id}', [TagController::class, 'show']);
    Route::put('/tags/{id}', [TagController::class, 'update']);
    Route::delete('/tags/{id}', [TagController::class, 'destroy']);

    // Section Routes
    Route::get('/sections', [SectionController::class, 'index']);
    Route::post('/sections', [SectionController::class, 'store']);
    Route::get('/sections/{id}', [SectionController::class, 'show']);
    Route::put('/sections/{id}', [SectionController::class, 'update']);
    Route::delete('/sections/{id}', [SectionController::class, 'destroy']);

    // Category Routes
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    // // User Profile Routes
    // Route::get('/profile', [UserProfileController::class, 'show']);
    // Route::put('/profile', [UserProfileController::class, 'update']);
});

// User Profile Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::put('/profile', [UserProfileController::class, 'update']);

    // Show saved and liked items
    Route::get('/profile/saved-items', [UserProfileController::class, 'showSavedItems']);
    Route::get('/profile/liked-items', [UserProfileController::class, 'showLikedItems']);

    // Unlike and unsave actions
    Route::delete('/profile/saved-items/{itemId}/unsave', [UserProfileController::class, 'unsaveItem']);
    Route::delete('/profile/liked-items/{itemId}/unlike', [UserProfileController::class, 'unlikeItem']);
});


// Admin and SuperAdmin Routes with specific middleware for authorization
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    // Additional admin routes
});

Route::middleware(['auth:sanctum', 'super-admin'])->group(function () {
    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'dashboard']);
    // Additional super admin routes
});
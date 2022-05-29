<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

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


// Home
Route::get('/', 'Auth\LoginController@home');
Route::get('/about', 'Static\AboutController@show');
Route::get('/services', 'Static\ServicesController@show');
Route::get('/faq', 'Static\FAQController@show');
Route::get('/contact', 'Static\ContactController@show');

//Search
Route::get('/search/', 'SearchController@searchList')->name('search');
//Route::get('paginate', 'SearchController@searchList');

// Auctions
Route::get('catalog', 'AuctionController@listcatalog');
Route::get('auctions', 'AuctionController@list');
Route::get('auctions/{auction_id}', 'AuctionController@show');
Route::put('auctions/{auction_id}/follow', 'AuctionFollowController@follow');
Route::delete('auctions/{auction_id}/unfollow', 'AuctionFollowController@unfollow');
Route::get('auctions/{auction_id}/bids', 'BidController@listByAuction');
Route::get('auctions/{auction_id}/bid/{bid_id}', 'BidController@show');
Route::get('auctions/{auction_id}/comments', 'CommentController@listByAuction');
Route::put('auctions/{auction_id}/new_comment', 'CommentController@create');
Route::get('auctions/{auction_id}/edit', 'AuctionController@editPage');
Route::put('auctions/{auction_id}/edit/update', 'AuctionController@edit');


// Profiles
Route::get('profile/{user_id}', 'ProfileController@show');
Route::get('profile/{user_id}/', 'ProfileController@show');
Route::delete('profile/{user_id}', 'ProfileController@delete');
Route::put('profile/{user_id}/follow', 'UserFollowController@follow');
Route::delete('profile/{user_id}/unfollow', 'UserFollowController@unfollow');
Route::get('profile/{user_id}/edit', 'ProfileController@editPage');
Route::put('profile/{user_id}/edit/update', 'ProfileController@edit');
Route::get('profile/{user_id}/bid_history', 'BidController@listByUser');
Route::get('profile/{user_id}/comment_history', 'CommentController@listByUser');
Route::get('profile/public_auctions/{user_id}', 'AuctionController@listPublic');
Route::get('profile/{user_id}/followers', 'ProfileController@listFollowers');
Route::get('profile/{user_id}/following', 'ProfileController@listFollowing');
Route::get('profile/{user_id}/notifications', 'NotificationController@list');
Route::put('profile/{user_id}/notifications/', 'NotificationController@update');
Route::put('profile/{user_id}/notifications/check', 'NotificationController@checkAll');

Route::get('profile/{user_id}/change_balance', 'ProfileController@credit');
Route::post('profile/{user_id}/change_balance/withdraw', 'ProfileController@withdrawCredit');
Route::post('profile/{user_id}/change_balance/deposit', 'ProfileController@depositCredit');

//Admin
Route::get('admin/{user_id}/requests', 'AdminRequestController@list');
Route::put('admin/{user_id}/requests/', 'AdminRequestController@update');


// API
Route::post('auctions', 'AuctionController@create');
Route::delete('api/auctions/{auction_id}', 'AuctionController@delete');
Route::put('api/auctions/{auction_id}/', 'BidController@create');


// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Admin
Route::get('dashboard', 'DashboardController@show');

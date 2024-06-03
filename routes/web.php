<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PictureController;
use App\Models\Album;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $albums = Album::paginate(10);
    return view('albums.index', compact('albums'));
});



Route::resource('albums', AlbumController::class);
Route::resource('pictures', PictureController::class);

Route::get('check-count-pictures/{album_id}',[AlbumController::class,'checkContPicturesInAlbum']);
Route::get('/get/albums/all/{except_album_id}', [AlbumController::class, 'getAllAlbums'])->name('albums.all');


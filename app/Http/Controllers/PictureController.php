<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([

            'album_id' => 'required|exists:albums,id',
            'photos' => 'array',
            'photos.*.name' => 'required_with:photos.*.file|string',
            'photos.*.file' => 'required_with:photos.*.name|file'
        ]);

        if (isset($request->photos) && count($request->photos)>0){
            foreach ($request->photos as $photo) {
                $filePath = $photo['file']->store('pictures', 'public');

                Picture::create([
                    'name' => $photo['name'],
                    'album_id' => $request->album_id,
                    'file_path' => $filePath
                ]);
            }
        }


        return redirect()->route('albums.show', $request->album_id);
    }


    public function destroy(Picture $picture)
    {
        $albumId = $picture->album_id;
        $picture->delete();
        return redirect()->route('albums.show', $albumId);
    }
}

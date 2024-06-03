<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::paginate(10);
        return view('albums.index', compact('albums'));
    }

    public function create()
    {
        return view('albums.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'photos' => 'array',
            'photos.*.name' => 'required_with:photos.*.file|string',
            'photos.*.file' => 'required_with:photos.*.name|file'
        ]);

        $album = Album::create(['name' => $request->name]);
        if (isset($request->photos) && count($request->photos)>0){
            foreach ($request->photos as $photo) {
                $filePath = $photo['file']->store('pictures', 'public');

                Picture::create([
                    'name' => $photo['name'],
                    'album_id' => $album->id,
                    'file_path' => $filePath
                ]);
            }
        }


        return redirect()->route('albums.index');
    }



    public function show(Album $album)
    {
        return view('albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate(['name' => 'required']);
        $album->update($request->all());
        return redirect()->route('albums.index');
    }


    public function checkContPicturesInAlbum($id)
    {
        // Fetch the album by its ID
        $album = Album::find($id);

        // Check if the album exists
        if (!$album) {
            return response()->json(['error' => 'Album not found'], 404);
        }

        // Get the count of pictures in the album
        $picturesCount = $album->pictures()->count();

        // Return the count as a JSON response
        return response()->json(['picturesCount' => $picturesCount]);
    }

    public function destroy(Album $album,Request $request)
    {

        if ($album->pictures->count() > 0) {
          if (isset($request->type) && $request->type == "transfer"){
              $targetAlbumId = $request->input('target_album');
              $this->movePicturesToAnotherAlbum($album, $targetAlbumId);
          }else{
              $this->deleteAllPictures($album);
          }
            $album->delete();
        } else {
            $album->delete();
        }
        return redirect()->route('albums.index');
    }

    public function getAllAlbums($id)
    {
        // Retrieve all albums except the one with the specified ID
        $albums = Album::where('id', '!=', $id)->get();
        return response()->json($albums);
    }

    private function movePicturesToAnotherAlbum(Album $album, $targetAlbumId)
    {
        $targetAlbum = Album::find($targetAlbumId);

        if (!$targetAlbum) {
            return redirect()->back()->with('error', 'Target album not found');
        }

        foreach ($album->pictures as $picture) {
            $picture->album_id = $targetAlbumId;
            $picture->save();
        }
    }

    private function deleteAllPictures(Album $album)
    {
        foreach ($album->pictures as $picture) {
            // Delete the picture file from storage
            Storage::delete($picture->file_path);
            // Delete the picture record from the database
            $picture->delete();
        }
    }


}

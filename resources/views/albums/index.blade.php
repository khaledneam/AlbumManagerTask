@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <h1>Albums</h1>
        <a href="{{ route('albums.create') }}" class="btn btn-primary mb-3">Create New Album</a>
        @if($albums->count() > 0)
            <div class="list-group">

                    <table class="table ">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Album Name</th>
                            <th scope="col">Actions</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($albums as $key=>$album)
                            <tr>
                                <th scope="row">{{ $key+ 1 }}</th>
                                <td><a href="{{ route('albums.show', $album) }}" >
                                        {{ $album->name }}
                                    </a></td>
                                <td>
                                    <a href="{{ route('albums.edit', $album) }}" class="btn btn-warning ">Edit Album</a>

                                    <button type="button" class="btn btn-primary delete-album" data-id="{{ $album->id }}">
                                       Delete
                                    </button>

                                </td>

                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                {{ $albums->links() }}
            </div>
        @else
            <p>No albums found. Create one to get started!</p>
        @endif
    </div>





    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                    <div class="modal-body">
                        <input type="hidden" name="album_id" class="album_id">
                        <div class="form-check">

                            <label class="form-check-label" for="radio1">
                                <input type="radio" class="form-check-input" id="radio1" name="type" value="delete" checked>Delete album with Pictures
                            </label>
                        </div>
                        <div class="form-check">

                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="radio2" name="type" value="transfer">Delete album and transfer picturs to another album
                            </label>
                        </div>

                        <div class="form-group" id="selectAlbumContainer" style="display:none;">
                            <label for="target_album">Select Target Album</label>
                            <select class="form-control target_album" id="target_album" name="target_album">

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary delete-album-w-or-t-picture ">Delete</button>
                    </div>

            </div>
        </div>
    </div>



@endsection

@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <h1>{{ $album->name }}</h1>


        <h2>Pictures</h2>
        <form action="{{ route('pictures.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="album_id" value="{{ $album->id }}">
            <div id="photos">

            </div>
            <button type="button" id="add-photo" class="btn btn-secondary ">Add Another Photo</button>
            <button type="submit" class="btn btn-success ">Upload</button>
        </form>

        @if($album->pictures->count() > 0)
            <div class="row mt-4">
                @foreach($album->pictures as $picture)
                    <div class="col-3">
                        <div class="card mb-2">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $picture->name }}</h5>
                                <img src="{{ asset('storage/' . $picture->file_path) }}" alt="{{ $picture->name }}" class="img-fluid picture-thumbnail">
                                <form action="{{ route('pictures.destroy', $picture) }}" method="POST" class="d-inline mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete Picture</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No pictures in this album. Upload some to get started!</p>
        @endif
    </div>
@endsection

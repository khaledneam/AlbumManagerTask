@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <h1>Edit Album</h1>
        <form action="{{ route('albums.update', $album) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Album Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $album->name }}" required>
            </div>
            <button type="submit" class="btn btn-success mt-2">Update</button>
        </form>
    </div>
@endsection

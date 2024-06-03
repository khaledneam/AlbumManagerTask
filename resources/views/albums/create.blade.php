@extends('layouts.app')

@section('content')
    <div class="mt-4">
        <h1>Create Album</h1>
        <form action="{{ route('albums.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Album Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div id="photos">

            </div>

            <button type="button" id="add-photo" class="btn btn-secondary mb-3">Add Another Photo</button>
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection

@extends('dashboard.layouts.app')
@section('content')
    @foreach($posts as $post)
        @include('partials.post_card',['profileFlag' => true])
    @endforeach


    <!-- MODAL UPDATE POST-->
    @foreach ($posts as $editpost)

        <div class="modal fade" id="update_post{{ $editpost->id }}" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('posts.update', $editpost) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="postTitle" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $editpost->title }}">
                            </div>
                            <div class="mb-3">
                                <label for="postDescription" class="form-label">Description</label>
                                <input type="text" name="description" class="form-control"
                                       value="{{ $editpost->description }}">
                            </div>
                            <div class="mb-3">
                                <label for="postImage" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control"
                                       id="postImage">
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                            </button>
                            <input type="submit" class="btn btn-warning" value="Update">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- END MODAL UPDATE POST-->

@endsection

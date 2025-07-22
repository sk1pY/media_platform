<!-- MODAL UPDATE POST-->
<div class="modal fade" id="update_post{{ $post->id }}" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.posts.update', $post) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $post->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short description</label>
                        <input type="text" name="short_description" class="form-control"
                               value="{{ $post->short_description }}">
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Description</label>

                        <input id="x" value="{{$post->description}}" type="hidden" name="description">
                        <trix-editor input="x"></trix-editor>
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
<!-- END MODAL UPDATE POST-->

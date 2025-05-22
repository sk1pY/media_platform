@extends('admin.layouts.index')
@section('content')
  <div class="p-3">
      <h4>Комментарии</h4>
      <hr>
      <table id="table" class="table table-sm table-bordered table-striped small align-middle text-center">
          <thead>
          <tr class="text-center align-middle">
              <th scope="col" class="col-4">Пост</th>
              <th scope="col" class="col-2">Комментатор</th>
              <th scope="col" class="col-3">Комментарий</th>
              <th scope="col" class="col-2">Дата</th>
              <th scope="col" class="col-1">Действия</th>
          </tr>
          </thead>
          <tbody class="tablecontents">
          @foreach( $comments as $comment )
              <tr class="align-middle">

                  <td class="text-center" >
                      <p class="text-truncate" style="max-width: 120px;" title="{{ $comment->post->title }}">
                          {{ $comment->post->title }}
                      </p>                </td>
                  <td class=" text-center ">
                      {{ $comment->user->name }}
                  </td>
                  <td class="text-center text-truncate" style="max-width: 300px;" >
                      {{ $comment->text }}
                  </td>
                  <td class="text-center" style="max-width: 300px;" >
                      {{ $comment->created_at }}
                  </td>
                  <td class=" text-center ">
                      <form action="{{ route('admin.comments.destroy', ['comment' => $comment->id]) }}" method="post" class="ms-2">
                          @csrf
                          @method('delete')
                          <button class="btn btn-sm"
                                  onclick="return confirm('Точно удалить?')">
                              <i type="submit" class="bi bi-x"></i>
                          </button>
                      </form>
                  </td>
              </tr>

          @endforeach
          </tbody>
      </table>
      <div class="mt-4">
          {{ $comments->links('pagination::bootstrap-5') }}
      </div>
  </div>


@endsection

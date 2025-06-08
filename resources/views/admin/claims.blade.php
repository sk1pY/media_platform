@extends('layouts.admin')
@section('admin-content')
    <div class="p-3">
        <h4>Жалобы</h4>
        <hr>
        <table id="table" class="table table-sm table-bordered table-striped small text-center align-middle">
            <thead>
            <tr>
                <th scope="col" class="col-1">#</th>
                <th scope="col" class="col-3">Пост</th>
                <th scope="col" class="col-3">Описание жалобы</th>
                <th scope="col" class="col-2">Статус</th>
                <th scope="col" class="col-1">Действия</th>
            </tr>
            </thead>
            <tbody id="tablecontents">
            @foreach($claims as $claim)
                <tr class="align-middle">
                    <td class="text-center">
                        {{ $claim->id }}
                    </td>
                    <td class="text-center">
                        <a href="{{route('posts.show',$claim->post)}}">{{ $claim->post->title }}</a>
                    </td>
                    <td class="text-center">
                        {{ $claim->title }}
                    </td>
                    <td class="text-center">
                        <select name="status"
                                class="claim-update"
                                data-url="{{route('admin.claims.update',$claim)}}">
                            @foreach($statuses as $stat)
                                <option value="{{ $stat }}" {{$claim->status === $stat? 'selected':''}}>{{$stat}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="text-center">

                        <form action="{{ route('admin.claims.destroy', $claim->id) }}" method="post"
                              style="display: inline;">
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

    </div>
@endsection

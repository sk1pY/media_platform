@extends('admin.layouts.index')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <table id="table" class="table table-sm table-bordered table-striped small">
        <thead>
        <tr class="text-center align-middle">
            <th scope="col" class="col-1">id</th>
            <th scope="col" class="col-3">Post</th>
            <th scope="col" class="col-2">complain</th>
            <th scope="col" class="col-2">status</th>
            <th scope="col" class="col">Actions</th>
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
                        <button class="btn btn-sm btn-light text-danger">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    {{--        <div class="mt-4">--}}
    {{--            {{ $claims->links('pagination::bootstrap-5') }}--}}
    {{--        </div>--}}


@endsection

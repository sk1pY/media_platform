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
        @foreach($complains as $complain)
            <tr class="align-middle">
                <td class="text-center">
                    {{ $complain->id }}
                </td>
                <td class="text-center">
                    {{ $complain->post->title }}
                </td>
                <td class="text-center">
                    {{ $complain->name }}
                </td>
                <td class="text-center">
                    <form action="{{ route('admin.complains.update',$complain->id) }}" method="post">
                        @csrf
                        @method('put')
                        <select name="status">
                            @foreach($statuses as $stat)
                                <option value="{{$stat}}" {{$complain->status == $stat? 'selected':''}}>{{$stat}}</option>
                            @endforeach
                        </select>
                        <input type="submit" >
                    </form>
                </td>
                <td class="text-center">

                    <form action="{{ route('admin.complains.destroy', $complain->id) }}" method="post"
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
    {{--    <div class="mt-4">--}}
    {{--        {{ $posts->links('pagination::bootstrap-5') }}--}}
    {{--    </div>--}}

    <script src="{{asset('js/table.js')}}"></script>

@endsection

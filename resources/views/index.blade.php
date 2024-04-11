<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@foreach($posts as $post)
    <table>
        <tr>
            {{ $post->title }}
        </tr>
        <tr>
            <form action="{{ route('tasks.delete',$post->id) }}" method="post">
                @csrf
                @method('DELETE')
                {{--   // <input type="text" name="text">--}}
                <input type="submit" value="delete">
            </form>
        </tr>
    </table>
@endforeach
<form action="{{ route('tasks.create') }}" method="post">
    @csrf
    <input type="text" name="title">
    <input type="text" name="description">
    <input type="submit">

</form>
</body>
</html>

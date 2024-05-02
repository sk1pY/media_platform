<form action="{{ route('create') }}" method="post">
@csrf
<input type="text" name="title">
<input type="text" name="description">
<input type="submit">
</form>

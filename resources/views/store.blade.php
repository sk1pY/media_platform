<form action="{{ route('tasks.create') }}" method="post">
@csrf
<input type="text" name="title">
<input type="text" name="description">
<input type="submit">
</form>

@extends('dashboard.layouts.app')
@section('content')
                    <form action="{{ route('profile.update',$user) }}" enctype="multipart/form-data"
                          method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Имя</label>
                            <input name="name" type="text" class="form-control" id="exampleFormControlInput1"
                                   value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2" class="form-label">Почта</label>
                            <input name="email" type="email" class="form-control" id="exampleFormControlInput2"
                                   value="{{ $user->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput3" class="form-label">Фото профиля</label>
                            <input name="image" type="file" class="form-control" id="exampleFormControlInput3">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput3" class="form-label">Фото обложки профиля</label>
                            <input name="image_cover" type="file" class="form-control" id="exampleFormControlInput3">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть
                        </button>
                        <input type="submit" value="Обновить" class="btn btn-primary">
                    </form>
@endsection

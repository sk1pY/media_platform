@extends('layouts.app')
@section('content')
    <div class="col-7 mx-auto">
    <div >
        <h1>{{$task -> title}}</h1>
        <p class="fw-bold">Author: {{$task -> user -> name}}</p>
    </div>
    <p>{{$task -> description}}</p>

    <form action="{{ route('comment.store') }}" method="POST">
        @csrf
        <input type="text" name="text">
        <input type="hidden" name="task_id" value="{{ $task -> id }}">
        <input type="submit">
    </form>
    </div>
    @if( count($comments )>0 )
        <section class="gradient-custom">
            <div class="container my-5 py-5">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12 col-lg-10 col-xl-8">
                        @foreach($comments as $comment)
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="row">
                                        <div class="col">
                                            <div class="d-flex flex-start">
                                                <img class="rounded-circle shadow-1-strong me-3"
                                                     src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(10).webp"
                                                     alt="avatar" width="65"
                                                     height="65"/>

                                                <div class="flex-grow-1 flex-shrink-1">
                                                    <div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-1">
                                                                {{ $comment -> user -> name }} <span
                                                                    class="small">- {{$comment ->  created_at}}</span>
                                                            </p>
                                                            <a href="#!"><i class="fas fa-reply fa-xs"></i><span
                                                                    class="small"> reply</span></a>
                                                        </div>
                                                        <p class="small mb-0">
                                                            {{$comment ->  text}}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection


@extends('layouts.app')
@section('title', 'Admin panel')
@section('content')

    <style>
        .full-width-container {
            width: 100vw;
            margin-left: calc(-50vw + 50%);
        }
    </style>
    <div class="container">
        <div class="container-fluid full-width-container">
            <div class="row">

                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <a href="" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <span class="fs-5 d-none d-sm-inline">Admin panel</span>
                        </a>
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li>
                                <a href="{{ route('all.posts.users') }}"  class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Posts</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cat.index') }}" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Categories</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route("users_admin") }}" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0 align-middle">
                                    <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Roles</span>
                                </a>
                            </li>
                        </ul>
                        <hr>
                    </div>
                </div>
                <div class="col-9">
                    @yield('content_admin')
                </div>

            </div>
            </div>

    </div>


@endsection

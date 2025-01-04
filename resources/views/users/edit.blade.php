@extends('layouts.header')
@section('title', 'Edit user data')
@section('users_navbar_state', 'active')

@section('additional_style')
@vite(['resources/css/users-style.css'])
@endsection

@section('content')
@section('navbar_header_button')
<span id="header_users_edit">Edit user</span>
@endsection

<div class="container-fluid">
    <div class="content-container main-container">
        <section class="content">
            <div class="container-fluid mt-4">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form id="editForm" class="" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    <div class="row justify-content-center ml-5 mr-5">
                        <div class="col-md-8">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>User information</b></h4><br /><br />
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <div class="row mb-3 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" class="form-control text-center @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" required maxlength="255">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email" class="form-label">Email:</label>
                                            <input type="email" class="form-control text-center @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="row mb-4 ml-2 mr-2">
                                        <div class="col-sm-6">
                                            <label for="role" class="form-label">Role:</label>
                                            <select class="form-select text-center @error('role') is-invalid @enderror" id="role" name="role" required>
                                                @foreach ($roles as $role)
                                                <option value="{{ $role->name }}" {{ $user->roles[0]->name == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card no-shadow">
                                <div class="card-body">
                                    <h4 class="card-title pl-4"><b>Actions</b></h4><br /><br />
                                    <div class="row mb-4 ml-2 mr-2">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success w-100">Save changes</button>
                                        </div>
                                    </div>
                </form>
                <form action="{{ route('admin.users.reset_password') }}" method="POST">
                    <div class="row mb-4 ml-2 mr-2">
                        @csrf
                        <div class="col-sm-12">
                            <input type="hidden" name="email" id="email" value="{{ $user->email }}" />
                            <button class="btn btn-primary w-100">Reset password</button>
                        </div>
                    </div>
                </form>
                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}">
                    <div class="row mb-3 ml-2 mr-2">
                        <div class="col-sm-12">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Delete user</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection
@section('custom-scripts')
@endsection
@extends('layouts.header')
@section('title', 'Users')
@section('users_navbar_state', 'active')
@section('additional_style')
@endsection
@section('navbar_header_button')
<a href="{{ route('admin.users.create') }}" class="add-new-button">Add user</a>
@endsection

@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
            <div class="container-fluid">
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
                <div class="text-center mb-4">
                    <h4><b>Users</b></h4>
                </div>
                <div>
                    <table id="users-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Credentials</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ ucfirst($user->roles[0]->name) }}</td>
                                <form action="{{ route('admin.users.reset_password') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $user->email }}" id="email" name="email" />
                                    <td class="text-center"><button type="submit" class="btn btn-primary">Reset password</button></td>
                                </form>
                                <td class="text-center">
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" type="button" class="btn btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@section('custom-scripts')
@vite(['resources/js/users/index.js'])
@endsection

@endsection
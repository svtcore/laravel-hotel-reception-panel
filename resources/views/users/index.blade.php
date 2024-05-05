@extends('layouts.header')
@section('title', 'Users')
@section('users_navbar_state', 'active')
@section('additional_style')
@endsection
@section('navbar_header_button')
<a href="{{ route('admin.users.create') }}" class="add-new-button">Add new user</a>
@endsection

@section('content')
<div class="container-fluid">
    <div class="content-container main-container">
        <div class="content-header">
            <div class="container-fluid mt-4">
                <!-- Session Messages Handling -->
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
                <!-- Users Table -->
                <div class="mt-4 text-center">
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
                            <!-- Iterate through users -->
                            @foreach ($users as $user)
                            <tr>
                                <!-- Display user data -->
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ ucfirst($user->roles[0]->name) }}</td>
                                <!-- Form to reset password -->
                                <form action="{{ route('admin.users.reset_password') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $user->email }}" id="email" name="email"/>
                                    <td class="text-center"><button type="submit" class="btn btn-primary">Reset password</button></td>
                                </form>
                                <!-- Form for user actions -->
                                <td class="text-center">
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                        <div class="btn-group mr-2" role="group" aria-label="First group">
                                            <!-- Edit user button -->
                                            <a href="{{ route('admin.users.edit', $user->id) }}" type="button" class="btn btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @csrf
                                            @method('DELETE')
                                            <!-- Delete user button -->
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
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

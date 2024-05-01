@extends('layouts.header_forms')
@section('content')
    <div class="reset-page">
        <div class="form">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-header">Reset Password</div>
                <div class="form-group">
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="New Password" />
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password_confirmation" id="password-confirm" placeholder="Confirm Password" />
                </div>

                <button id="submit" type="submit">Reset Password</button><br>
            </form>
        </div>
    </div>
@endsection

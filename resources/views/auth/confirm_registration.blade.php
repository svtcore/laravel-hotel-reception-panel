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
        <form method="POST" action="{{ route('confirm.submit') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-header">Almost complete. Set up your password</div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" id="password-confirm" class="form-control" placeholder="Confirm password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
</div>
@endsection
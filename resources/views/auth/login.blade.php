<!DOCTYPE html>
<html>

<head>
    @vite(['resources/css/login-style.css'])
</head>

<body>

    <div class="login-page">
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
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-header">Authorization</div>
                <div class="form-group">
                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" />
                </div>
                <div class="form-group">
                    <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="Password" />
                </div>

                <button id="submit" type="submit">Login</button><br>
            </form>
        </div>
    </div>

</body>

</html>

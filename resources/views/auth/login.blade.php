<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .login-page {
            width: 360px;
            padding: 8% 0 0;
            margin: auto;
        }

        .form {
            position: relative;
            background: #ffffff;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            border: 1px solid grey;
            border-radius: 10px;
        }

        .form input {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
            border: 1px solid grey;
            border-radius: 10px;
        }

        .form button {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #0275d8;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #ffffff;
            font-size: 14px;
            border-radius: 10px;
        }

        .form button:hover {
            background: #0252d8;
        }

        .form-header {
            font-family: "Roboto", sans-serif;
            margin-bottom: 30px;
            font-size: 24px;
            color: #333333;
        }

        body {
            background: #dedad9;
        }

        .form-group {
            position: relative;
            margin-bottom: 15px;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 12px;
        }

        .is-invalid {
            border: 1px solid #dc3545;
        }

        .alert-danger {
            background-color: #f8d7da; /* Previous error background color */
            border-color: #f5c6cb; /* Previous border color */
            color: #721c24; /* Previous error text color */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        .alert-danger ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .alert-danger li {
            margin-bottom: 5px;
        }
    </style>
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

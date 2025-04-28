<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RGMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Tailwind CSS -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #e3f2fd; /* Light blue background */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #1e88e5; /* Deep blue text color */
        }

        .container {
            text-align: center;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #0d47a1; /* Darker blue for heading */
            font-weight: 600;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary {
            background-color: #1976d2;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1565c0;
        }

        .btn-secondary {
            background-color: #42a5f5;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #1e88e5;
        }

        .btn-outline {
            background-color: white;
            color: #2196f3;
            border: 1px solid #2196f3;
        }

        .btn-outline:hover {
            background-color: #2196f3;
            color: white;
        }

        /* Optional - To add some margin between the logo and the title */
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo Image -->
        <img src="/img/uniten_logo.png" alt="RGMS Logo" class="logo">

        <h1>Welcome to Research Grant Management System</h1>

        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline">Create an Account</a>
                @endif
            @endauth
        @endif
    </div>
</body>
</html>

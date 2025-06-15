<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartCR</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Tailwind CSS -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;

            /* full-screen cover background */
            background: url('/img/digitalized_background.jpg') no-repeat center center;
            background-size: cover;

            /* optional color overlay if image fails or for a tint: */
            /* background-color: #e0f2f1; */
            
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #00695c; /* adjust text color for contrast */
        }

        .container {
            text-align: center;
            background: #ffffff; /* slight white translucency */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }


        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #004d40;          /* Deep teal for heading */
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
            background-color: #009688;  /* Teal */
            color: white;
        }

        .btn-primary:hover {
            background-color: #00796b;  /* Darker teal */
        }

        .btn-secondary {
            background-color: #4db6ac;  /* Lighter teal */
            color: white;
        }

        .btn-secondary:hover {
            background-color: #26a69a;  /* Medium teal */
        }

        .btn-outline {
            background-color: white;
            color: #009688;             /* Teal border/text */
            border: 1px solid #009688;
        }

        .btn-outline:hover {
            background-color: #009688;
            color: white;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo Image -->
        <div class="d-flex justify-content-center align-items-center mb-4" style="gap: 1.5rem;">
            <img src="/img/uniten_logo.png"         alt="UNITEN Logo"   class="logo" style="max-height: 80px;">
            <img src="/img/ERP_Logo.gif"            alt="ERP Logo"      class="logo" style="max-height: 80px;">
        </div>

        <h1>Welcome to SmartCR Management System</h1>

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

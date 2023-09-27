<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{asset('images/bumn_favicon.png')}}">
    <script src="https://hcaptcha.com/1/api.js" async defer></script>
    <style>
        body {
            background-color: #f0f0f0;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-right a:hover {
            color: #2AB1E4;
        }

        .form-container {
            animation: slideIn 0.5s ease-in-out forwards;
            opacity: 0;
            transform: translateY(-20px);
            text-align: center;
            padding: 20px;
        }

        .welcome-message {
            font-family: "Arial", sans-serif;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .rounded-input {
            border-radius: 20px;
        }

        .rounded-button {
            border-radius: 20px;
        }

        .input-label {
            text-align: left;
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <form action="/employee/login" method="post" class="max-w-md mx-auto my-8 p-6 bg-white rounded shadow form-container">
        <div class="welcome-message">Welcome Back!</div>
        @if ($errors->any())
        <div class="mb-4 bg-red-100 p-4 rounded text-red-600">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @csrf
        <div class="mb-4">
            <label for="username" class="block text-gray-700 input-label">Username</label>
            <input value="{{ old('username') }}" type="username" name="username" id="username" placeholder="Username"
                class="w-full px-4 py-2 border border-gray-300 rounded-input focus:outline-none focus:border-blue-300">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 input-label">Password</label>
            <input type="password" name="password" id="password" placeholder="Password"
                class="w-full px-4 py-2 border border-gray-300 rounded-input focus:outline-none focus:border-blue-300">
        </div>
        <div class="h-captcha" data-sitekey="ddd61fd9-6651-4ab6-ab13-aefe7c1eafb9"></div>
        <button type="submit"
            class="w-full bg-sky-500 text-white py-2 px-4 mt-2 rounded-button hover:bg-blue-400 transition-colors">Login</button>
    </form>
</body>
</html>

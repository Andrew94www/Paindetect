<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back!</title>
    <!-- Tailwind CSS CDN inclusion -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%); /* Soft gradient background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1.5rem; /* Increased padding for better spacing on small screens */
            box-sizing: border-box; /* Ensure padding is included in element's total width and height */
        }
        .card {
            background-color: #ffffff;
            border-radius: 1rem; /* More rounded corners */
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); /* Stronger, softer shadow */
            padding: 2.5rem; /* Increased padding inside the card */
            width: 100%;
            max-width: 30rem; /* Slightly wider card */
            border: 1px solid #e2e8f0; /* Subtle border */
        }
        .form-input {
            width: 100%;
            padding: 0.875rem 1.25rem; /* Slightly larger padding for inputs */
            border-radius: 0.625rem; /* More rounded input fields */
            border: 1px solid #cbd5e1; /* Lighter gray border */
            transition: all 0.2s ease-in-out;
            background-color: #f8fafc; /* Very light background for inputs */
        }
        .form-input:focus {
            outline: none;
            border-color: #4f46e5; /* Deeper indigo on focus */
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.3); /* Softer, wider focus ring */
            background-color: #ffffff; /* White background on focus */
        }
        .btn-primary {
            background-color: #4f46e5; /* Deeper indigo */
            color: #ffffff;
            padding: 0.875rem 2rem; /* Larger button padding */
            border-radius: 0.625rem; /* More rounded button */
            font-weight: 700; /* Bolder text */
            transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Subtle button shadow */
        }
        .btn-primary:hover {
            background-color: #4338ca; /* Even deeper indigo on hover */
            transform: translateY(-1px); /* Slight lift effect */
            box-shadow: 0 6px 8px -2px rgba(0, 0, 0, 0.15), 0 3px 5px -2px rgba(0, 0, 0, 0.08);
        }
        .btn-primary:active {
            transform: translateY(0); /* Press down effect */
            box-shadow: none;
        }
        .error-message {
            color: #ef4444; /* Red */
            font-size: 0.875rem;
            margin-top: 0.5rem; /* More space above error message */
            font-weight: 500;
        }
        .link-text {
            color: #4f46e5; /* Deeper indigo */
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease-in-out;
        }
        .link-text:hover {
            color: #4338ca; /* Even deeper indigo on hover */
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="text-center mb-8">
        <!-- Optional: Add a simple icon or logo here -->
        <svg class="mx-auto h-12 w-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
        </svg>
        <h2 class="text-4xl font-extrabold text-gray-900 mt-4">Welcome Back!</h2>
        <p class="text-gray-600 mt-2">Sign in to your account</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-5">
            <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
            <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
            <input type="password" id="password" name="password" class="form-input" required autocomplete="current-password">
            @error('password')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                    Remember me
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-sm link-text" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="btn-primary w-full">
                Login
            </button>
        </div>
    </form>

    <p class="text-center text-gray-600 text-sm mt-8">
        Don't have an account? <a href="{{ route('register') }}" class="link-text">Register here</a>
    </p>
</div>
</body>
</html>

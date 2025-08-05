<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Tailwind CSS CDN inclusion -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-xl */
            padding: 2rem;
            width: 100%;
            max-width: 28rem; /* max-w-sm */
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem; /* rounded-lg */
            border: 1px solid #d1d5db; /* border-gray-300 */
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .form-input:focus {
            outline: none;
            border-color: #6366f1; /* indigo-500 */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5); /* ring-indigo-200 */
        }
        .btn-primary {
            background-color: #6366f1; /* indigo-600 */
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem; /* rounded-lg */
            font-weight: 600; /* font-semibold */
            transition: background-color 0.2s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #4f46e5; /* indigo-700 */
        }
        .error-message {
            color: #ef4444; /* red-500 */
            font-size: 0.875rem; /* text-sm */
            margin-top: 0.25rem;
        }
        .link-text {
            color: #6366f1; /* indigo-600 */
            font-weight: 600;
            text-decoration: none;
        }
        .link-text:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="card">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Register</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required autofocus>
            @error('name')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
            @error('email')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
            <input type="password" id="password" name="password" class="form-input" required>
            @error('password')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="btn-primary w-full">
                Register
            </button>
        </div>
    </form>

    <p class="text-center text-gray-600 text-sm mt-6">
        Already registered? <a href="{{ route('login') }}" class="link-text">Login</a>
    </p>
</div>
</body>
</html>

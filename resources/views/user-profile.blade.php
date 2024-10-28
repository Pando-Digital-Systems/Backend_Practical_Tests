<!-- resources/views/user-profile.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS via CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">User Profile</h1>

        @if (session('access_token'))
            <script>
                const token = '{{ session('access_token') }}';
                console.log('Access Token:', token);
                // You can use the token for API calls here
            </script>
        @endif

        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Welcome, {{ $user->name }}</h2>
                <p class="card-text">Email: {{ $user->email }}</p>
                <!-- Add any additional user information you want to display -->
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies (optional, if needed for interactivity) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

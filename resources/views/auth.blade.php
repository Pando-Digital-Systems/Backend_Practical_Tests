<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Register</h2>
    <form id="register-form">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <div id="register-errors" class="mt-2 text-danger"></div>
    </form>

    <hr>

    <h2>Login</h2>
    <form id="login-form">
        @csrf
        <div class="form-group">
            <label for="login_email">Email</label>
            <input type="email" class="form-control" id="login_email" name="email" required>
        </div>
        <div class="form-group">
            <label for="login_password">Password</label>
            <input type="password" class="form-control" id="login_password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <div id="login-errors" class="mt-2 text-danger"></div>
    </form>
</div>

<script>
    document.getElementById('register-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        
        axios.post('/api/register', formData)
            .then(response => {
                alert(response.data.message);
                // Optionally, reset the form here
                this.reset();
            })
            .catch(error => {
                if (error.response && error.response.data) {
                    const errors = error.response.data;
                    document.getElementById('register-errors').innerHTML = Object.values(errors).join('<br>');
                }
            });
    });

    document.getElementById('login-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        axios.post('/api/login', formData)
            .then(response => {
                alert('Login successful! Token: ' + response.data.access_token);
                // Store token or redirect user as needed
            })
            .catch(error => {
                if (error.response && error.response.data) {
                    const errors = error.response.data;
                    document.getElementById('login-errors').innerHTML = errors.error || 'Invalid credentials';
                }
            });
    });
</script>

</body>
</html>

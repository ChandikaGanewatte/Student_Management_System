
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Student Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: "Segoe UI", sans-serif;
            background: linear-gradient(135deg, #edf3ff, #f8faff, #e8f0ff);
        }

        .login-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 70px rgba(27, 48, 85, .12);
        }

        .login-banner {
            padding: 55px 40px;
            color: white;
            background: linear-gradient(145deg, #142544, #3478f6);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-banner .brand-icon {
            font-size: 55px;
            margin-bottom: 24px;
        }

        .login-banner h1 {
            font-size: 32px;
            font-weight: 750;
            line-height: 1.3;
        }

        .login-banner p {
            color: #d7e4ff;
            line-height: 1.8;
        }

        .login-form {
            padding: 55px 40px;
        }

        .login-form h2 {
            font-weight: 750;
            color: #1c2d4c;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #34435c;
        }

        .form-control {
            padding: 13px 14px;
            border-radius: 10px;
            border-color: #dfe6f0;
        }

        .form-control:focus {
            border-color: #3478f6;
            box-shadow: 0 0 0 3px #3478f61c;
        }

        .login-button {
            padding: 13px;
            border-radius: 10px;
            font-weight: 650;
            background: #3478f6;
            border: none;
        }

        .login-button:hover {
            background: #2563eb;
        }

        @media(max-width: 700px) {
            .login-card {
                grid-template-columns: 1fr;
                max-width: 440px;
            }

            .login-banner {
                padding: 30px;
            }

            .login-banner h1 {
                font-size: 25px;
            }

            .login-banner .brand-icon {
                font-size: 38px;
                margin-bottom: 10px;
            }

            .login-form {
                padding: 32px 25px;
            }
        }
    </style>
</head>

<body>
<div class="login-card">

    <section class="login-banner">
        <div class="brand-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>

        <h1>Student Management System</h1>

        <p class="mt-3 mb-0">
            Manage student records efficiently with a simple,
            secure and modern administration system.
        </p>
    </section>

    <section class="login-form">
        <h2>Welcome Back!</h2>
        <p class="text-secondary mb-4">
            Sign in to access your dashboard.
        </p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="admin@student.com"
                    autocomplete="username"
                    required
                    autofocus
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>

                <div class="input-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                    <button type="button"
                            class="btn btn-outline-secondary"
                            id="togglePassword"
                            aria-label="Show password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input"
                       type="checkbox"
                       name="remember"
                       value="1"
                       id="remember">

                <label class="form-check-label small"
                       for="remember">
                    Remember me
                </label>
            </div>

            <button type="submit"
                    class="btn btn-primary login-button w-100">
                Sign In <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </form>

        <p class="text-center text-secondary small mt-4 mb-0">
            Student Management System
        </p>
    </section>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('password');
        const icon = this.querySelector('i');

        const showPassword = password.type === 'password';

        password.type = showPassword ? 'text' : 'password';
        icon.className = showPassword ? 'bi bi-eye-slash' : 'bi bi-eye';

        this.setAttribute(
            'aria-label',
            showPassword ? 'Hide password' : 'Show password'
        );
    });
</script>

</body>
</html>

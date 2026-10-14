
<!DOCTYPE html>
<html lang="en">
<head>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Student Management System')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            color: #222;
        }
        header {
            background: #173b67;
            color: white;
            padding: 18px 6%;
        }
        header a { color: white; text-decoration: none; }
        main { max-width: 1050px; margin: 30px auto; padding: 0 18px; }
        .card {
            background: white; padding: 24px; border-radius: 8px;
            box-shadow: 0 2px 8px #00000012; margin-bottom: 20px;
        }
        .btn {
            display: inline-block; padding: 9px 13px; border: 0;
            border-radius: 4px; text-decoration: none; cursor: pointer;
            background: #173b67; color: white; font-size: 14px;
        }
        .danger { background: #c0392b; }
        .secondary { background: #64748b; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #edf2f7; }
        input {
            width: 100%; box-sizing: border-box; padding: 10px;
            margin: 6px 0 16px; border: 1px solid #bbb; border-radius: 4px;
        }
        label { font-weight: bold; }
        .photo { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 15px; }
        .success { background: #d1fae5; color: #065f46; }
        .error { background: #fee2e2; color: #991b1b; }
        .actions { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
        .actions form { margin: 0; }
        .actions button { white-space: nowrap; }
        @media (max-width: 650px) {
            .table-wrap { overflow-x: auto; }
            table { min-width: 650px; }
        }
        
        /* Modal background */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            padding: 20px;
            overflow-y: auto;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Modal content */
        .modal-content {
            background: #fff;
            width: 100%;
            max-width: 550px;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .modal-close {
            position: absolute;
            top: 12px;
            right: 16px;
            border: none;
            background: transparent;
            font-size: 28px;
            cursor: pointer;
        }

        .modal-content input {
            width: 100%;
            box-sizing: border-box;
            margin: 6px 0 15px;
            padding: 10px;
        }

        .modal-content label {
            display: block;
            font-weight: 600;
        }

        body.modal-open {
            overflow: hidden;
        }
        
        .status-active {
            color: #15803d;
            font-weight: bold;
        }

        .status-deleted {
            color: #b91c1c;
            font-weight: bold;
        }

        
        .site-title {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin: 0;
        }

        .site-title a {
            color: #f8f7fc;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .site-title a:hover {
            color: #6366f1;
        }
    </style>
</head>
<body>
    <header>
        <h2 class="site-title">
            <a href="{{ route('students.index') }}">
                STUDENT MANAGEMENT SYSTEM
            </a>
        </h2>
    </header>

    <main>
        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <strong>Please correct these errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);

            if (modal) {
                modal.classList.add('show');
                document.body.classList.add('modal-open');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);

            if (modal) {
                modal.classList.remove('show');

                if (!document.querySelector('.modal.show')) {
                    document.body.classList.remove('modal-open');
                }
            }
        }

        document.querySelectorAll('.modal').forEach(function (modal) {
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.modal.show').forEach(function (modal) {
                    closeModal(modal.id);
                });
            }
        });
    </script>
</body>
</html>

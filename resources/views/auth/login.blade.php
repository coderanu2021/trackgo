<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Security - TrackGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #0f172a;
            --white: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: radial-gradient(circle at top right, #f8fafc 0%, #e2e8f0 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        h1 { font-family: 'Outfit', sans-serif; }

        .auth-container {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            position: relative;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: var(--primary);
            filter: blur(150px);
            opacity: 0.15;
            top: -100px;
            right: -100px;
            z-index: -1;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 30px;
            padding: 3.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 2rem;
            display: inline-block;
        }
        .logo span { color: var(--primary); }

        .auth-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .auth-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.65rem;
            margin-left: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: all 0.3s;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 1.15rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: all 0.3s;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }
        .btn-submit:hover {
            background: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4);
        }

        .auth-footer {
            margin-top: 2.5rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }
        .auth-footer a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .error-badge {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo">TrackGo<span>.</span></div>
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Verify your identity to access the terminal.</p>
            
            @if($errors->any())
                <div class="error-badge">
                    <i class="fas fa-circle-exclamation"></i> Invalid credentials detected.
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">AUTHENTICATION KEY (EMAIL)</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="name@company.com" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">SECURITY PHRASE (PASSWORD)</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-submit">Initialize Session</button>
            </form>

            <div class="auth-footer">
                Secured by TrackGo Pulse Protocol &copy; {{ date('Y') }}
            </div>
        </div>
    </div>
</body>
</html>

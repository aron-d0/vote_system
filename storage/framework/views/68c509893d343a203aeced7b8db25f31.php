<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoteHub - Online Voting System</title>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f9; /* light grey */
            color: #1f2937; /* dark grey text */
        }

        /* Navigation */
        nav {
            background-color: #1e3a8a; /* deep blue */
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        nav a {
            color: #fff;
            font-weight: 600;
            margin-left: 1rem;
            text-decoration: none;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #dbeafe; /* light blue */
        }

        /* Layout */
        .container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 60px); /* full screen minus nav */
        }

        /* Hero Section */
        .hero {
            flex: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: linear-gradient(135deg, #0b0669 0%, #1b2b60 100%);
            color: #fff;
            padding: 2rem;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
        }
        .hero .buttons a {
            background-color: #fff;
            color: #1e3a8a;
            padding: 0.75rem 1.5rem;
            margin: 0.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .hero .buttons a:hover {
            background-color: #e0e7ff;
            transform: scale(1.05);
        }

        /* Features Section */
        .features {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            padding: 1rem 2rem;
            background-color: #f9fafb;
        }
        .feature {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .feature h3 {
            color: #1e3a8a;
            margin-bottom: 0.5rem;
        }
        .feature p {
            color: #4b5563;
            font-size: 0.95rem;
        }

        /* Footer */
        footer {
            background-color: #1e3a8a;
            color: #fff;
            text-align: center;
            padding: 0.75rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="text-2xl font-bold">VoteHub</div>
        <div>
            <?php if(Route::has('login')): ?>
                <a href="<?php echo e(route('login')); ?>">Login</a>
                <a href="<?php echo e(route('register')); ?>">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <!-- Hero Section -->
        <section class="hero">
            <h1>Welcome to VoteHub</h1>
            <p>A secure and transparent online voting platform designed for fair elections. Cast your vote, view live results, and make your voice heard with confidence.</p>
            <div class="buttons">
                <a href="<?php echo e(route('votes.create')); ?>">🗳️ Start Voting</a>
                <a href="<?php echo e(route('votes.index')); ?>">📊 View Results</a>
                <a href="<?php echo e(route('login')); ?>">🔐 Sign In</a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="feature">
                <div class="text-4xl mb-3">🔒</div>
                <h3>Secure</h3>
                <p>Your votes are encrypted and stored securely with advanced protection.</p>
            </div>
            <div class="feature">
                <div class="text-4xl mb-3">🎯</div>
                <h3>Transparent</h3>
                <p>Real-time results and complete vote tallying with full transparency.</p>
            </div>
            <div class="feature">
                <div class="text-4xl mb-3">⚡</div>
                <h3>Fast & Easy</h3>
                <p>Simple voting interface that works on any device, anywhere.</p>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        © <?php echo e(date('Y')); ?> VoteHub — Secure Online Voting System | All Rights Reserved
    </footer>
</body>
</html>
<?php /**PATH /Users/aron/Downloads/vote_system/resources/views/welcome.blade.php ENDPATH**/ ?>
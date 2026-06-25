<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoteHub - Online Voting System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            font-family: Figtree, Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }

        .page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: #0f172a;
            border-bottom: 1px solid #1f2937;
            color: #fff;
        }

        .topbar-inner {
            max-width: 1120px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .brand {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nav-links a,
        .button {
            border-radius: 6px;
            padding: 10px 14px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
        }

        .nav-links a {
            color: #e5e7eb;
        }

        .nav-links a:hover {
            background: #1f2937;
        }

        .hero {
            background: #0f172a;
            color: #fff;
        }

        .hero-inner {
            max-width: 1120px;
            margin: 0 auto;
            padding: 72px 24px 56px;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(280px, 0.9fr);
            gap: 40px;
            align-items: center;
        }

        .hero h1 {
            margin: 0;
            font-size: clamp(40px, 7vw, 72px);
            line-height: 1;
            letter-spacing: 0;
        }

        .hero p {
            margin: 20px 0 0;
            max-width: 650px;
            color: #cbd5e1;
            font-size: 18px;
            line-height: 1.7;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }

        .button-primary {
            background: #2563eb;
            color: #fff;
        }

        .button-primary:hover {
            background: #1d4ed8;
        }

        .button-secondary {
            background: #fff;
            color: #111827;
        }

        .button-secondary:hover {
            background: #e5e7eb;
        }

        .status-panel {
            background: #111827;
            border: 1px solid #374151;
            border-radius: 8px;
            padding: 24px;
        }

        .status-panel h2 {
            margin: 0 0 16px;
            font-size: 18px;
            color: #f9fafb;
        }

        .status-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 0;
            border-top: 1px solid #374151;
            color: #cbd5e1;
        }

        .status-row strong {
            color: #fff;
        }

        .features {
            max-width: 1120px;
            margin: 0 auto;
            padding: 36px 24px 48px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .feature {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 22px;
        }

        .feature h3 {
            margin: 0 0 8px;
            color: #111827;
            font-size: 18px;
        }

        .feature p {
            margin: 0;
            color: #4b5563;
            line-height: 1.6;
        }

        footer {
            margin-top: auto;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            text-align: center;
            padding: 18px;
            font-size: 14px;
        }

        @media (max-width: 760px) {
            .topbar-inner {
                align-items: flex-start;
                flex-direction: column;
            }

            .hero-inner,
            .features {
                grid-template-columns: 1fr;
            }

            .hero-inner {
                padding-top: 48px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <header class="topbar">
            <div class="topbar-inner">
                <div class="brand">VoteHub</div>
                <nav class="nav-links" aria-label="Main navigation">
                    @auth
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="hero-inner">
                    <div>
                        <h1>VoteHub</h1>
                        <p>
                            A secure online voting system for managing elections, candidates,
                            authenticated voters, ballot submission, and real-time result monitoring.
                        </p>
                        <div class="actions">
                            @auth
                                <a class="button button-primary" href="{{ route('dashboard') }}">Open Dashboard</a>
                                <a class="button button-secondary" href="{{ route('votes.create') }}">Start Voting</a>
                            @else
                                <a class="button button-primary" href="{{ route('login') }}">Log In To Vote</a>
                                <a class="button button-secondary" href="{{ route('register') }}">Create Account</a>
                            @endauth
                        </div>
                    </div>

                    <aside class="status-panel" aria-label="System highlights">
                        <h2>System Modules</h2>
                        <div class="status-row">
                            <span>Authentication</span>
                            <strong>Required</strong>
                        </div>
                        <div class="status-row">
                            <span>Admin Controls</span>
                            <strong>Role Based</strong>
                        </div>
                        <div class="status-row">
                            <span>API Access</span>
                            <strong>Bearer Token</strong>
                        </div>
                        <div class="status-row">
                            <span>Voting Rule</span>
                            <strong>Once Per Election</strong>
                        </div>
                    </aside>
                </div>
            </section>

            <section class="features" aria-label="Features">
                <article class="feature">
                    <h3>Authenticated Voting</h3>
                    <p>Voters must log in before accessing the ballot and can submit only one ballot per active election.</p>
                </article>
                <article class="feature">
                    <h3>Election Management</h3>
                    <p>Admins can create elections, assign candidates by position, and control voting windows.</p>
                </article>
                <article class="feature">
                    <h3>Results And Analytics</h3>
                    <p>Votes are counted by position with public result views and admin-only summaries.</p>
                </article>
            </section>
        </main>

        <footer>
            &copy; {{ date('Y') }} VoteHub Online Voting System
        </footer>
    </div>
</body>
</html>

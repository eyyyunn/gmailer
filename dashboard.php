<?php
require 'config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --success: #28a745;
            --success-dark: #218838;
            --text: #2d3436;
            --text-light: #636e72;
            --background: #f8f9fa;
            --sidebar: #ffffff;
            --card: #ffffff;
            --border: #e9ecef;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        body {
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: var(--sidebar);
            box-shadow: var(--shadow);
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }
        
        .brand {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding: 0 0.5rem;
        }
        
        .brand h1 {
            font-size: 1.5rem;
            color: var(--primary);
            margin-left: 10px;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover, .nav-item.active {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }
        
        .nav-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .logout {
            margin-top: auto;
            color: var(--text-light);
        }
        
        .logout:hover {
            background: rgba(255, 71, 87, 0.1);
            color: #ff4757;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }
        
        .header h2 {
            font-weight: 600;
            font-size: 1.5rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
        }
        
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            background: var(--primary);
            padding: 8px;
            color: white;
        }
        
        /* Dashboard Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: var(--card);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .stat-info h3 {
            font-size: 1.8rem;
            margin-bottom: 0.2rem;
        }
        
        .stat-info p {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        /* Form Styling */
        .form-container {
            background: var(--card);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        
        .form-title {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid var(--border);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-light);
        }
        
        input[type="email"],
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }
        
        input[type="email"]:focus,
        input[type="text"]:focus,
        textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }
        
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        button {
            padding: 14px;
            background: var(--success);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            width: 100%;
        }
        
        button:hover {
            background: var(--success-dark);
        }
        
        button:active {
            transform: scale(0.98);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                padding: 1rem 0.5rem;
            }
            
            .brand h1, .nav-item span {
                display: none;
            }
            
            .nav-item {
                justify-content: center;
                padding: 0.8rem;
            }
            
            .nav-item i {
                margin-right: 0;
            }
            
            .main-content {
                margin-left: 80px;
            }
        }
        
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .main-content {
                padding: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .sidebar {
                width: 0;
                overflow: hidden;
                position: fixed;
                padding: 1rem 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .menu-toggle {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1000;
                background: var(--primary);
                color: white;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: var(--shadow);
            }
            
            .sidebar.active {
                width: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="menu-toggle" id="menuToggle">☰</div>
    
    <div class="sidebar" id="sidebar">
        <div class="brand">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="7.5 4.21 12 6.81 16.5 4.21"></polyline>
                <polyline points="7.5 19.79 7.5 14.6 3 12"></polyline>
                <polyline points="21 12 16.5 14.6 16.5 19.79"></polyline>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
            <h1>AdminPanel</h1>
        </div>
        
        <a href="#" class="nav-item active">
            <i>📧</i>
            <span>Send Email</span>
        </a>
        <a href="#" class="nav-item">
            <i>📊</i>
            <span>Analytics</span>
        </a>
        <a href="#" class="nav-item">
            <i>👥</i>
            <span>Users</span>
        </a>
        <a href="#" class="nav-item">
            <i>⚙️</i>
            <span>Settings</span>
        </a>
        
        <a href="logout.php" class="nav-item logout">
            <i>🚪</i>
            <span>Logout</span>
        </a>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h2>Dashboard</h2>
            <div class="user-info">
                <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPjxwYXRoIGQ9Ik0yMCAydjRhMiAyIDAgMCAxLTIgMmEyIDIgMCAwIDEtMi0yVjJhMiAyIDAgMCAwLTItMmgyYTIgMiAwIDAgMCAwIDRoNmE2IDYgMCAwIDEgNiA2djZhMiAyIDAgMCAxLTIgMmgtMmEyIDIgMCAwIDEtMi0yIj48L3BhdGg+PHBhdGggZD0iTTIgMTJ2NmEyIDIgMCAwIDAgMiAyaDJhMiAyIDAgMCAwIDItMlYxMmE2IDYgMCAwIDEgNi02aDZhMiAyIDAgMCAwLTItMmgtNmEyIDIgMCAwIDAtMiAyIj48L3BhdGg+PC9zdmc+">
                <span>Administrator</span>
            </div>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">📧</div>
                <div class="stat-info">
                    <h3>152</h3>
                    <p>Emails Sent</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-info">
                    <h3>842</h3>
                    <p>Total Users</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-info">
                    <h3>97%</h3>
                    <p>Success Rate</p>
                </div>
            </div>
        </div>
        
        <div class="form-container">
            <h3 class="form-title">Send Email</h3>
            <form action="send_mail.php" method="post">
                <div class="form-group">
                    <label for="to">Recipient Email</label>
                    <input type="email" id="to" name="to" placeholder="Enter recipient email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Enter email subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Compose your message" required></textarea>
                </div>
                
                <button type="submit">Send Email</button>
            </form>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>
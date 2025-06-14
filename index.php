<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management Login</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background for black theme */
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        /* Container for Login Options */
        .login-container {
            text-align: center;
            max-width: 800px;
            width: 100%;
        }

        .inner-title h2 {
            font-size: 2rem;
            color: #ffffff;
            margin-bottom: 30px;
        }

        .login-grid {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        /* Individual Login Boxes */
        .login-box {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 220px;
        }

        .login-box img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .login-box h6 {
            margin-bottom: 10px;
            font-size: 1.1rem;
            color: #ffffff;
        }

        .login-button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745; /* Green color for button */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="inner-title">
            <h2>Logins</h2>
        </div>
        
        <div class="login-grid">
            <!-- User Login -->
            <div class="login-box">
                <img src="images/Ent.jpeg" alt="User Login">
                <h6>User Login</h6>
                <a href="user_login.php" target="_blank" style="text-decoration: none;">
                    <button class="login-button">Click Here</button>
                </a>
            </div>

            <!-- Manager Login -->
            <div class="login-box">
                <img src="images/Mager.jpg" alt="Manager Login">
                <h6>Manager Login</h6>
                <a href="manager_login.php" target="_blank" style="text-decoration: none;">
                    <button class="login-button">Click Here</button>
                </a>
            </div>

            <!-- Admin Login -->
            <div class="login-box">
                <img src="images/adn.jpeg" alt="Admin Login">
                <h6>Admin Login</h6>
                <a href="admin_login.php" target="_blank" style="text-decoration: none;">
                <button class="login-button">Click Here</button>
                </a>

            </div>
        </div>
    </div>
</body>
</html>

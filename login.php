<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If already logged in, redirect to dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = "Username and password are required!";
    } else {
        $usersFile = 'data/users.json';
        if (!file_exists($usersFile)) {
            $error = "User database not found.";
        } else {
            $users = json_decode(file_get_contents($usersFile), true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($users)) {
                $error = "Invalid user data.";
            } else {
                $userFound = false;

                foreach ($users as $user) {
                    if (isset($user['username'], $user['password']) && $user['username'] === $username) {
                        $userFound = true;
if ($password === $user['password']) {
    $_SESSION["user"] = $username;
    header("Location: dashboard.php");
    exit();
} else {
    $error = "Invalid password!";
}

                        break;
                    }
                }

                if (!$userFound) {
                    $error = "Username not found!";
                }
            }
        }
    }

    // Store error temporarily to show on reload (POST-Redirect-GET)
    $_SESSION['error'] = $error;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Get error if redirected
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Zenvesture Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
   * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #fff 0%, #f7e4d8 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
      animation: fadeInBody 1s ease forwards;
    }

    @keyframes fadeInBody {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .header {
      position: absolute;
      top: 32px;
      left: 32px;
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .logo {
      width: 48px;
      height: 48px;
      background: #7B4019;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      color: #fff;
      font-weight: bold;
      animation: popLogo 1s ease;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    @keyframes popLogo {
      0% { transform: scale(0.5); }
      80% { transform: scale(1.2); }
      100% { transform: scale(1); }
    }

    .shop-name {
      font-size: 2rem;
      font-weight: 700;
      color: #7B4019;
      letter-spacing: 1px;
    }

    .login-container {
      background: #fff;
      padding: 48px 32px;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 360px;
      z-index: 2;
      animation: slideUp 1.2s ease-out forwards;
    }

    @keyframes slideUp {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .login-container input {
      width: 100%;
      padding: 14px 16px;
      font-size: 1rem;
      border: 1.5px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .login-container input:focus {
      border-color: #7B4019;
      outline: none;
      box-shadow: 0 0 0 3px rgba(123, 64, 25, 0.1);
    }

    .password-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .password-wrapper .toggle-password {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #7B4019;
      cursor: pointer;
      font-size: 1rem;
    }

    .login-btn {
      width: 100%;
      background: #7B4019;
      color: #fff;
      font-size: 1.05rem;
      padding: 14px;
      border: none;
      border-radius: 8px;
      margin-top: 12px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    .login-btn:hover {
      background: #5d2f12;
      transform: scale(1.03);
    }

    .forgot-link {
      text-align: right;
      margin-top: 6px;
    }

    .forgot-link a {
      text-decoration: none;
      color: #7B4019;
      font-size: 0.95rem;
    }

    .forgot-link a:hover {
      text-decoration: underline;
    }

    .footer {
      position: absolute;
      bottom: 24px;
      font-size: 0.8rem;
      text-align: center;
      color: #7B4019;
    }

    .footer a {
      text-decoration: none;
      color: #7B4019;
      font-weight: bold;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    /* Bubbles background */
    .bubbles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 0;
      overflow: hidden;
      pointer-events: none;
    }

    .bubble {
      position: absolute;
      bottom: -100px;
      background: rgba(123, 64, 25, 0.1);
      border-radius: 50%;
      animation: bubbleRise 12s linear infinite;
    }

    @keyframes bubbleRise {
      0% { transform: translateY(0) scale(1); opacity: 0.4; }
      100% { transform: translateY(-120vh) scale(1.5); opacity: 0; }
    }

    @media (max-width: 600px) {
      .login-container {
        padding: 32px 20px;
        margin: 0 10px;
      }
    }
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #fff 0%, #f7e4d8 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
      animation: fadeInBody 1s ease forwards;
    }
    
  </style>
</head>
<body>
  <div class="bubbles">
    <div class="bubble" style="width: 40px; height: 40px; left: 10%; animation-delay: 0s;"></div>
    <div class="bubble" style="width: 60px; height: 60px; left: 25%; animation-delay: 2s;"></div>
    <div class="bubble" style="width: 30px; height: 30px; left: 45%; animation-delay: 4s;"></div>
    <div class="bubble" style="width: 50px; height: 50px; left: 60%; animation-delay: 1s;"></div>
    <div class="bubble" style="width: 70px; height: 70px; left: 80%; animation-delay: 3s;"></div>
  </div>


  <div class="header">
    <div class="logo">Z</div>
    <div class="shop-name">Zenvesture</div>
  </div>

  <form class="login-container" method="POST" action="">
    <?php if (!empty($error)): ?>
      <p style="color:red; text-align:center; margin-bottom: 16px;">
        <?= htmlspecialchars($error) ?>
      </p>
    <?php endif; ?>
    <input type="text" name="username" placeholder="Username" autocomplete="username" required />
    <div class="password-wrapper" style="margin-top: 20px;">
      <input type="password" name="password" placeholder="Password" autocomplete="current-password" required id="password"/>
      <span class="toggle-password" onclick="togglePassword()"><i class="fa fa-eye"></i></span>
    </div>
    <div class="forgot-link">
      <a href="#" onclick="alert('Contact Admin to reset your password.'); return false;">Forgot password?</a>
    </div>
    <button class="login-btn" type="submit">Login</button>
  </form>

  <div class="footer">
    Developed by <a href="https://www.facebook.com/mhm-humaidh" target="_blank">Cyber Bro IT Solution</a> © 2025
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const icon = document.querySelector(".toggle-password i");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        passwordInput.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
      }
    }
  </script>
</body>
</html>

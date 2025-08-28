<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - ORANGE BITE</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="form-container">
  <h2>Login</h2>
  <form action="backend/login_process.php" method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <p>Don’t have an account? <a href="register.html">Register</a></p>
  </form>
</div>
</body>
</html>
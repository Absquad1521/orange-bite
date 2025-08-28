<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - ORANGE BITE</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="form-container">
  <h2>Create Account</h2>
  <form action="backend/register_process.php" method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm" placeholder="Confirm Password" required>
    <input type="tel" name="phone" placeholder="+94 77 1234567" required>
    <input type="file" name="profile_pic" accept="image/*" required>
    <button type="submit">Register</button>
    <p>Already have an account? <a href="login.html">Login</a></p>
  </form>
</div>
</body>
</html>
<?php
session_start();
require __DIR__ . '/db.php';

// Only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../register.php');
  exit;
}

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$pass     = $_POST['password'] ?? '';
$confirm  = $_POST['confirm'] ?? '';
$phone    = trim($_POST['phone'] ?? '');

if ($name === '' || $email === '' || $pass === '' || $confirm === '' || $phone === '') {
  die('All fields are required.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die('Invalid email.');
}

if (strlen($pass) < 6) {
  die('Password must be at least 6 characters.');
}

if ($pass !== $confirm) {
  die('Passwords do not match.');
}

// Check email exists
$chk = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$chk->execute([$email]);
if ($chk->fetch()) {
  die('Email already registered.');
}

// Handle profile pic (optional)
$profileFile = null;
if (!empty($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
  $allowed = ['image/jpeg','image/png','image/webp'];
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime  = finfo_file($finfo, $_FILES['profile_pic']['tmp_name']);
  finfo_close($finfo);

  if (!in_array($mime, $allowed, true)) {
    die('Profile image must be JPG/PNG/WEBP.');
  }

  if ($_FILES['profile_pic']['size'] > 2*1024*1024) { // 2MB
    die('Profile image too large (max 2MB).');
  }

  $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
  $profileFile = uniqid('pf_', true) . '.' . strtolower($ext);

  $dir = __DIR__ . '/../uploads/profiles/';
  if (!is_dir($dir)) { mkdir($dir, 0755, true); }

  if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $dir . $profileFile)) {
    die('Failed to save profile image.');
  }
}

// Store user
$hash = password_hash($pass, PASSWORD_BCRYPT);
$ins = $pdo->prepare("INSERT INTO users (name,email,password,phone,profile_pic) VALUES (?,?,?,?,?)");
$ins->execute([$name, $email, $hash, $phone, $profileFile]);

// Login session
$_SESSION['user_email'] = $email;

// Go home
header('Location: ../index.php');
exit;
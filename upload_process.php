<?php
session_start();
require __DIR__ . '/db.php';

if (!isset($_SESSION['user_email'])) {
  header('Location: ../login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../upload.php');
  exit;
}

$pic_name = trim($_POST['pic_name'] ?? '');
$category = trim($_POST['category'] ?? '');
$tags     = trim($_POST['tags'] ?? '');

if ($pic_name === '' || $category === '') {
  die('Picture name and category are required.');
}

// Get user id
$u = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$u->execute([$_SESSION['user_email']]);
$user = $u->fetch();
if (!$user) {
  die('User not found.');
}
$user_id = (int)$user['id'];

// Validate file
if (empty($_FILES['wallpaper']['name']) || $_FILES['wallpaper']['error'] !== UPLOAD_ERR_OK) {
  die('Please select a wallpaper to upload.');
}

$allowed = ['image/jpeg','image/png','image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime  = finfo_file($finfo, $_FILES['wallpaper']['tmp_name']);
finfo_close($finfo);

if (!in_array($mime, $allowed, true)) {
  die('Wallpaper must be JPG/PNG/WEBP.');
}

if ($_FILES['wallpaper']['size'] > 5*1024*1024) { // 5MB
  die('Wallpaper too large (max 5MB).');
}

$ext = pathinfo($_FILES['wallpaper']['name'], PATHINFO_EXTENSION);
$fname = uniqid('wp_', true) . '.' . strtolower($ext);

$dir = __DIR__ . '/../uploads/wallpapers/';
if (!is_dir($dir)) { mkdir($dir, 0755, true); }

if (!move_uploaded_file($_FILES['wallpaper']['tmp_name'], $dir . $fname)) {
  die('Failed to save wallpaper.');
}

// Save DB
$ins = $pdo->prepare("INSERT INTO wallpapers (user_id, pic_name, category, tags, file_path) VALUES (?,?,?,?,?)");
$ins->execute([$user_id, $pic_name, $category, $tags, $fname]);

header('Location: ../profile.php');
exit;
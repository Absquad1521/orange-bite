<?php
session_start();
require 'backend/db.php';

if(!isset($_SESSION['user_email'])){
    header("Location: login.html");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
$stmt->execute([$_SESSION['user_email']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile - ORANGE BITE</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header><a href="index.php">← Home</a></header>

<main>
  <div class="profile-card">
    <img src="<?php echo $user['profile_pic'] ? 'uploads/profiles/'.$user['profile_pic'] : 'assets/img/profile_default.png'; ?>" alt="Profile Picture">
    <h2><?php echo $user['name']; ?></h2>
    <p>Email: <?php echo $user['email']; ?></p>
    <p>Phone: <?php echo $user['phone']; ?></p>
    <button onclick="window.location.href='backend/logout.php'">Logout</button>
  </div>

  <h2 style="text-align:center; margin-top:30px;">Your Uploaded Wallpapers</h2>
  <div class="gallery">
    <?php
    $stmt = $pdo->prepare("SELECT * FROM wallpapers WHERE user_id=? ORDER BY uploaded_at DESC");
    $stmt->execute([$user['id']]);
    while($wall = $stmt->fetch()){
        echo '<div class="wallpaper">';
        echo '<img src="uploads/wallpapers/'.$wall['file_path'].'" alt="'.$wall['pic_name'].'">';
        echo '<p>'.$wall['pic_name'].'</p>';
        echo '<a href="uploads/wallpapers/'.$wall['file_path'].'" download>Download</a>';
        echo '</div>';
    }
    ?>
  </div>
</main>

<div class="mobile-menu">
  <a href="index.php">Home</a>
  <a href="upload.php">Upload</a>
  <a href="profile.php">Profile</a>
  <a href="terms.html">Terms</a>
  <a href="privacy.html">Privacy</a>
</div>
</body>
</html>
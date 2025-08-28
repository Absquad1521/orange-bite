<?php
session_start();
require 'backend/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ORANGE BITE - Home</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
  <div class="logo"><a href="index.php"><img src="logo.png" alt="ORANGE BITE Logo"></a></div>
</header>

<main>
  <h1>Latest Wallpapers</h1>
  <div class="gallery">
    <?php
    $stmt = $pdo->query("SELECT * FROM wallpapers ORDER BY uploaded_at DESC");
    while($wallpaper = $stmt->fetch()){
        echo '<div class="wallpaper">';
        echo '<img src="uploads/wallpapers/'.$wallpaper['file_path'].'" alt="'.$wallpaper['pic_name'].'">';
        echo '<p>'.$wallpaper['pic_name'].'</p>';
        echo '<a href="uploads/wallpapers/'.$wallpaper['file_path'].'" download>Download</a>';
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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload - ORANGE BITE</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header><a href="index.html">← Home</a></header>

<div class="form-container">
  <h2>Upload Wallpaper</h2>
  <form action="backend/upload_procees.php" method="post" enctype="multipart/form-data">
    <input type="file" name="wallpaper" accept="image/*" required>
    <input type="text" name="pic_name" placeholder="Wallpaper Name" required>
    <input type="text" name="category" placeholder="Category" required>
    <input type="text" name="tags" placeholder="Tags (comma separated)" required>
    <button type="submit">Upload</button>
  </form>
</div>

<div class="mobile-menu">
  <a href="index.html">Home</a>
  <a href="upload.html">Upload</a>
  <a href="profile.html">Profile</a>
  <a href="terms.html">Terms</a>
  <a href="privacy.html">Privacy</a>
</div>
</body>
</html>
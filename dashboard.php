<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php"); // balik ke login kalau belum login
  exit;
}
?>

<h2>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
<a href="logout.php">Logout</a>
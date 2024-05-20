<?php
// // Turn on errors
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();

// Fetch JSON data from API
$url = 'http://localhost:8888/backend/api.php?req=all_products';
$json = file_get_contents($url);

// Get data from jsonn
$data = json_decode($json, true);

if ($data === null) {
  // If non succesfull
  echo "Error decoding JSON data";
} else {
  // Store products details in the proucts session variable
  $_SESSION['products'] = $data;
}
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">

<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- Include the navbar and sidemenu -->
  <?php include 'components/navbar.php'; ?>
  <?php include 'components/sideMenu.php'; ?>

  <div style="display: flex; flex-direction: column; width: 100%;">
    <section>
      <?php include 'components/hero.php'; ?>
    </section>

    <section>
      <?php include 'components/tabsWithImages.php'; ?>
    </section>

    <section>
      <?php include 'components/productsList.php'; ?>
    </section>

    <section>
      <?php include 'components/banner.php'; ?>
    </section>
  </div>

  <?php include 'components/footer.php'; ?>
</body>

</html>
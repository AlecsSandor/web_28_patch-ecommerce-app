<?php

session_start();

// Check to see products are already stored in session
// The $_GET[pr] - refers to the parameter "pr" passed as part of the links address
if (!isset($_SESSION['product']) || $_SESSION['product'][0]['product_id'] !== $_GET['pr']) {
  // Fetch JSON data from API
  $url = 'http://localhost:8888/backend/api.php?pr=' . $_GET['pr'] . '';
  $json = file_get_contents($url);

  $data = json_decode($json, true);

  // Check if JSON decoding was successful
  if ($data === null) {
    // If not succesfull
    echo "Error decoding JSON data";
  } else {
    // Store products details in the proucts session variable
    $_SESSION['product'] = $data;
  }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">

<head>
  <meta charset="UTF-8">
  <title>Product</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- Include the navbar and sidemenu -->
  <?php include 'components/navbar.php'; ?>
  <?php include 'components/sideMenu.php'; ?>

  <div style="display: flex; flex-direction: column; width: 100%;">

    <section>
      <?php include 'components/singleProduct.php'; ?>
    </section>

  </div>

  <?php include 'components/footer.php'; ?>
</body>

</html>
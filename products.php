<?php
// // Turn on errors
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();

// Check to see products are already stored in session
if (!isset($_SESSION['products'])) {
  // Fetch JSON data from API
  $url = 'http://localhost:8888/backend/api.php?req=all_products';
  $json = file_get_contents($url);

  $data = json_decode($json, true);

  // Check if JSON decoding was successful
  if ($data === null) {
    echo "Error decoding JSON data";
  } else {
    // Store products details in the proucts session variable
    $_SESSION['products'] = $data;
  }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">

<head>
  <meta charset="UTF-8">
  <title>Products</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- Include the navbar and sidemenu -->
  <?php include 'components/navbar.php'; ?>
  <?php include 'components/sideMenu.php'; ?>

  <div class="about-wrapper">
    <!-- <section> -->
    <div class="header" style="background-image: url('assets/img/products.jpg');">
      <div style="text-align: center; padding-left: 5px; padding-right: 5px;">
        <p style="
                color: white;
                font-size: 27px;
                font-weight: 600;
                letter-spacing: 4px;
                padding: 10px;
                ">
          Products</p>
        <p style="
                color: white;
                font-size: 14px;
                font-weight: 200;
                ">
          Everything from A to Z!
        </p>
      </div>
    </div>
    <!-- <section> -->

    <div style="display: flex; flex-direction: column; width: 100%;">

      <section>
        <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
          <form id="searchForm" action="http://localhost:8888/backend/api.php" method="POST"
            style="display: flex; flex-direction: column; width: 300px;">
            <input type="hidden" name="action" value="search">

            <label for="text" style="padding-top: 30px;">Email:</label>
            <input type="text" id="text" name="text" required style="height: 60px;">

            <button type="submit" style="margin-top: 30px;">Search</button>
          </form>
        </div>
      </section>

      <section>
        <?php include 'components/productsList.php'; ?>
      </section>
    </div>

  </div>

  <?php include 'components/footer.php'; ?>
</body>

<script>

  // Submit the search string an refresh the page
  $(document).ready(function () {
        $("#searchForm").on('submit', function (event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "http://localhost:8888/backend/api.php",
                data: formData,
                success: function (response) {
                    window.location.href = "http://localhost:8888/products.php";
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                    $("#response").html("An error occurred: " + error);
                }
            });
        });
    });
</script>

</html>
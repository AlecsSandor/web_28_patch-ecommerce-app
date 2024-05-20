<!DOCTYPE html>
<html lang="<?php echo $language; ?>">

<head>
  <meta charset="UTF-8">
  <title>Contact</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- Include the navbar and sidemenu -->
  <?php include 'components/navbar.php'; ?>
  <?php include 'components/sideMenu.php'; ?>

  <div class="about-wrapper">
    <!-- <section> -->
    <div class="header" style="background-image: url('assets/img/contact.jpg');">
      <div style="text-align: center; padding-left: 5px; padding-right: 5px;">
        <p style="
                color: white;
                font-size: 27px;
                font-weight: 600;
                letter-spacing: 4px;
                padding: 10px;
                ">
          Contact</p>
        <p style="
                color: white;
                font-size: 14px;
                font-weight: 200;
                ">
          Leave us a message!
        </p>
      </div>
    </div>
    <!-- <section> -->

    <section>
      <div style="display: flex; flex-direction: column; align-items: center; width: 100%; color: black;">
        <h1 style="font-size: 50px; font-weight: 400;">Contact</h1>
        <form id="messageForm" action="http://localhost:8888/backend/api.php" method="POST"
          style="display: flex; flex-direction: column; width: 400px;">
          <input type="hidden" name="action" value="message">

          <label for="email" style="padding-top: 30px;">Email:</label>
          <input type="email" id="email" name="email" required style="height: 60px;">

          <label for="title" style="padding-top: 30px;">Title:</label>
          <input type="text" id="title" name="title" required style="height: 60px;">

          <label for="text" style="padding-top: 30px;">Text:</label>
          <input type="text" id="text" name="text" required style="height: 60px;">

          <button type="submit" style="margin-top: 30px; margin-bottom: 30px;">Submit</button>
        </form>
      </div>
    </section>
  </div>

  <?php include 'components/footer.php'; ?>
</body>

<script>

  // Submit the message
  $(document).ready(function () {
        $("#messageForm").on('submit', function (event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "http://localhost:8888/backend/api.php",
                data: formData,
                success: function (response) {
                    alert(response)
                    window.location.href = "http://localhost:8888/contact.php";
                },
                // Print errors in console
                error: function (xhr, status, error) {
                    console.error(xhr);
                }
            });
        });
    });
</script>

</html>
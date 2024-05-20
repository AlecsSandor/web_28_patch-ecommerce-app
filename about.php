<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
  <head>
    <meta charset="UTF-8">
    <title>About</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <!-- Include the navbar and sidemenu -->
    <?php include 'components/navbar.php'; ?>
    <?php include 'components/sideMenu.php'; ?>

    <div class= "about-wrapper">
      <!-- <section> -->
        <div class= "header" style = "background-image: url('assets/img/about.jpg');">
            <div
                style = "text-align: center; padding-left: 5px; padding-right: 5px;"
            >
                <p style = "
                color: white;
                font-size: 27px;
                font-weight: 600;
                letter-spacing: 4px;
                padding: 10px;
                ">
            About Us</p>
                <p style = "
                color: white;
                font-size: 14px;
                font-weight: 200;
                "
                >
            We are a top gaming store selling products for all ages and themes.
            </p>
            </div>
        </div>
      <!-- <section> -->

      <section style="display: flex; justify-content: center;">
        <div style="display: flex; flex-direction: column; align-items: center; width: 50%; color: black; font-size: 11px; padding-top: 30px; padding-bottom: 30px;">
          <p>
            Nullam lobortis, arcu a varius laoreet, enim ligula tristique sem, a tempus arcu urna eget mi. Aliquam in hendrerit lorem, vitae convallis nisi. Sed at efficitur lorem. Proin ornare nulla eu tellus convallis, quis euismod orci tristique. Sed non leo eget eros sagittis gravida quis pellentesque nunc. Quisque porttitor odio in felis ultricies, ac auctor orci porta. Praesent iaculis auctor leo vitae lacinia. Donec lacinia elementum varius. Integer lacus turpis, mattis id hendrerit non, ornare ut ligula. Ut elementum enim ante, vel elementum libero aliquet at. Sed sit amet gravida ex, sed suscipit dolor. Maecenas interdum quis ligula auctor imperdiet. Duis nec gravida nisi, nec dictum magna. Nullam ut aliquet tortor. Ut vel consectetur lectus. Nunc ultricies consectetur eros eget interdum. Fusce sed sodales ipsum, pellentesque malesuada purus. Fusce pellentesque at nisi ut semper. In dictum ac tortor sit amet feugiat. Etiam blandit venenatis orci ac consequat. Fusce sodales odio in pellentesque volutpat. In placerat sed felis in tristique. Ut ut nisl vel diam rutrum suscipit eu at ipsum. In sit amet pulvinar lectus, a viverra mauris. Duis non nunc sed sem tempor porttitor. In pellentesque eleifend leo, nec pulvinar dui tristique id.
          </p>

          <p>
            Mauris eget ipsum fermentum, laoreet lacus in, faucibus dolor. Mauris hendrerit sem vel sapien maximus, et ullamcorper urna faucibus. Donec imperdiet vel ipsum non vestibulum. Nunc eleifend pretium dignissim. Vivamus sit amet posuere orci. Vivamus commodo mi a nisl pharetra elementum. Pellentesque ut sem urna. Vivamus ex erat, egestas sit amet sollicitudin eu, pulvinar non nulla. Nam sit amet iaculis erat. Quisque vitae varius arcu. Sed leo arcu, viverra vitae lobortis tempus, congue at risus. Nam leo est, fringilla quis eros rhoncus, pharetra laoreet dolor.
          </p>
        </div>
      </section>
    </div>

    <?php include 'components/footer.php'; ?>
  </body>
</html>


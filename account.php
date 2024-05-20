<?php
session_start();
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">

<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Include the navbar and sidemenu -->
    <?php include 'components/navbar.php'; ?>
    <?php include 'components/sideMenu.php'; ?>

    <div style="display: flex; flex-direction: column; width: 100%;">
        <section>
            <div class="account-wrapper">
                <div style="display: flex; flex-direction: column; align-items: center; width: 80%;">
                    <?php

                    // If a user is logged in display orders otherwise show the login-register tabs
                    if (!isset($_SESSION['email'])) {
                        include 'components/login-register.php';
                    } else {

                        // Get orders  details
                        $url = 'http://localhost:8888/backend/api.php';

                        $data = array(
                            'action' => 'get_orders',
                            'user_id' => $_SESSION['user_id']
                        );

                        // Create the POST data as a query string
                        $options = array(
                            'http' => array(
                                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                                'method' => 'POST',
                                'content' => http_build_query($data),
                            ),
                        );

                        $context = stream_context_create($options);
                        $response = file_get_contents($url, false, $context);

                        // If errors ocure
                        if ($response === false) {
                            echo 'Something went wrong.';
                        } else {
                            // Create and assign the user_orders session variable
                            $_SESSION['user_orders'] = json_decode($response);
                        }

                        if ($_SESSION['user_role']) {
                            echo '<h2>Admin Account</h2>';
                        }
                        echo '<div>Hello ' . $_SESSION['email'] . '</div>';
                        echo '<h1> Orders </h2>';

                        // Print all the orders
                        if (isset($_SESSION['user_orders']) && count($_SESSION['user_orders']) > 0) {
                            foreach ($_SESSION['user_orders'] as $order) { 
                                echo '
                                    <div style="display: flex; flex-direction: column; width: 100%; background: rgb(245, 255, 180); align-items: center; margin-top: 15px;">
                                        <div style="display: flex; flex-direction: row">
                                            <div style="padding: 20px;">Order Id: '.$order->order_id.'</div>
                                            <div style="padding: 20px;">Order Timestamp: '.$order->order_date.'</div>
                                            <div style="padding: 20px;">Card used: '.$order->card_no.'</div>
                                            <div style="padding: 20px;">Address: '.$order->address.'</div>
                                        </div>
                                    </div>
                                ';
                            }
                        } else {
                            // If the user doesn't have any orders
                            echo '
                                <div style="display: flex; flex-direction: column; width: 100%; background: rgb(245, 255, 180); padding: 20px; align-items: center;">
                                    You have no orders yet.
                                </div>
                            ';
                        }
                        // Show logout button
                        echo '<button id="logoutButton" style="margin: 20px;">Log Out</button>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>

    <?php include 'components/footer.php'; ?>
</body>

<script>

    // Function to toggle between the login and register tabs
    function switchTabs() {
        var login_tab = document.getElementById('login_tab');
        var register_tab = document.getElementById('register_tab');

        if (login_tab.classList.contains('active')) {
            login_tab.classList.remove('active');
            register_tab.classList.add('active');
        } else {
            login_tab.classList.add('active');
            register_tab.classList.remove('active');
        }
    }

    // Submit the regsiter form
    $(document).ready(function () {
        $("#registerForm").on('submit', function (event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "http://localhost:8888/backend/api.php",
                data: formData,
                success: function (response) {
                    alert(response)
                    window.location.href = "http://localhost:8888/account.php";
                },
                error: function (xhr, status, error) {
                    // Print the error in console - used this for debugging
                    console.error(xhr);
                }
            });
        });
    });

    // Submit the login form
    $(document).ready(function () {
        $("#loginForm").on('submit', function (event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "http://localhost:8888/backend/api.php",
                data: formData,
                success: function (response) {
                    alert(response)
                    window.location.href = "http://localhost:8888/account.php";
                },
                error: function (xhr, status, error) {
                    // Print the error in console - used this for debugging
                    console.error(xhr);
                }
            });
        });
    });

    // Logout functionn
    $(document).ready(function () {
        // When the logout button is clicked
        $("#logoutButton").click(function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "http://localhost:8888/backend/api.php",
                data: { action: "logout" },
                success: function (response) {
                    
                    window.location.href = "http://localhost:8888/account.php";
                },
                error: function (xhr, status, error) {
                    // Print the error in console - used this for debugging
                    console.error(xhr);
                }
            });
        });
    });

</script>

</html>
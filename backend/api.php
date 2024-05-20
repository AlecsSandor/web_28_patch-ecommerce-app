<?php

// ------------------------------------
//      - All request for the database are  made to this file, which handles them by case and interacts with the dattabase.
// ------------------------------------


// // Turn on errors
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Set database login data
$username = "root";
$password = "root";
$database = "patch";
$host = 'localhost';


// CREATE A DATABASE CONNECTIONN -------------------------------------------------------------------------------------
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("The connection  failed: " . $e->getMessage());
}

// GET ALL PRODUCTS -------------------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['req']) && $_GET['req'] === 'all_products') {
    $stmt = $pdo->prepare(
        "SELECT product.*, category.category_title
        FROM product
        JOIN category ON product.category_id = category.category_id;"
    );
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // JSON encode the response
    $response = json_encode($products);

    // Configure the  header
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    // Return theJSON response
    echo $response;
}

// GET A PRODUCT BY ID -------------------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pr'])) {
    $stmt = $pdo->prepare(
        "SELECT product.*, category.category_title
        FROM product
        JOIN category ON product.category_id = category.category_id
        WHERE product.product_id = " . $_GET['pr'] . ";"
    );
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // JSON encode the response
    $response = json_encode($products);

    // Configure the  header
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    // Return theJSON response
    echo $response;
}

// ALL POST REQUESTS ARE HANDLED HERE ////////////////////////////////////////////////////////////////////////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    // Handle Login Requests -------------------------------------------------------------------------------------
    if ($action == 'login') {

        // Get the data from the form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate inputs
        if (empty($email) || empty($password)) {
            echo "One or more fields are empty!";
            exit;
        }

        // Get the  password from the database
        $stmt = $pdo->prepare("SELECT user_password, user_id, user_role FROM user WHERE user_email = :user_email");
        $stmt->bindParam(':user_email', $email);
        $stmt->execute();

        // Check if the user exists
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the provided password against the stored password
            if ($password === $row['user_password']) {
                // Password  correct
                echo "Login successful!";
                // Start a new session and set the session variables
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_role'] = $row['user_role'];
            } else {
                // Return a message of the password is not right
                echo "Invalid password.";
            }
        } else {
            // Return a message if the user does not exist
            echo "Invalid email.";
        }

    // Handle Register Requests -------------------------------------------------------------------------------------
    } elseif ($action == 'register') {

        // Get the data from the form
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate inputs
        if (empty($username) || empty($email) || empty($password)) {
            echo "One or more fields are empty!";
            exit;
        }
        if (strlen($password) < 5) {
            echo "Your password must be at least 5 characters long!";
            exit;
        }

        try {
            // Insert user into the database
            $stmt = $pdo->prepare("INSERT INTO user (user_name, user_email, user_password) VALUES (:user_name, :user_email, :user_password)");
            $stmt->bindParam(':user_name', $username);
            $stmt->bindParam(':user_email', $email);
            $stmt->bindParam(':user_password', $password);
            $stmt->execute();

            echo "Registration successful!";
        } catch (PDOException $e) {
            echo "Something went wrong, try again.";
        }

    // Handle Logout Requests -------------------------------------------------------------------------------------
    } elseif ($action == 'logout') {
        // Start session and remove the session email, user_id and user_orders variables thus loging the user out
        session_start();
        unset($_SESSION['email']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_orders']);
        echo 'You were logged out succesfuly!';

    // Handle Order Requests -------------------------------------------------------------------------------------
    } elseif ($action == 'order') {
        // Get the data from the form
        $user_address = $_POST['address'];
        $card_no = $_POST['card'];
        $user_id = (int)$_POST['user_id'];
        $products = $_POST['products'];
        
        try {
            // Insert user into the shop_order
            $stmt = $pdo->prepare("INSERT INTO shop_order (user_id, address, card_no) VALUES (:user_id, :user_address, :card_no)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':user_address', $user_address);
            $stmt->bindParam(':card_no', $card_no);
            $stmt->execute();
            
            // Get the id of the newly created order
            $newOrderId = $pdo->lastInsertId();

            // Insert user into the order_details
            foreach ($products as $productId) {
                $stmt = $pdo->prepare("INSERT INTO order_details (order_id, product_id) VALUES (:order_id, :product_id)");
                $stmt->bindParam(':order_id', $newOrderId);
                $stmt->bindParam(':product_id', $productId);
                $stmt->execute();
            }

            // Sending an email to the customer to let them know the order was succesfully placed
            session_start();
            // Create mail
            $to = $_SESSION['email'];
            $subject = 'Order Placed';
            $message = 'Your order  on PATCH  was succefully placed';

            //  Add headers
            $headers = 'From: patch@mail.com' . "\r\n" .
                'Reply-To: patch@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Try to send email
            if (mail($to, $subject, $message, $headers,"-f patch@email.here")) {
               
            } else {
                echo 'Email sending failed';
            }

            echo "Order succesfully placed, check your email for a receip!";
        } catch (PDOException $e) {
            echo "Something went wrong, try again.";
        }

    // Handle Get Order for a specific user Requests -------------------------------------------------------------------------------------
    } elseif ($action == 'get_orders') {
        // Get the data from the form
        session_start();
        $user_id = (int)$_POST['user_id'];

        // Selecte all orders of a user from shop_order
        try {
            $stmt = $pdo->prepare(
                "SELECT *
                FROM shop_order
                WHERE user_id =".$user_id.";"
            );
            $stmt->execute();
            $user_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // return the JSON encoded orders
            echo json_encode($user_orders);
        } catch (PDOException $e) {
            echo 'Something is not alright!';
        }

    // Handle Message Requests -------------------------------------------------------------------------------------
    } elseif ($action == 'message') { 

        // Get the data from the form
        $message_text = $_POST['text'];
        $message_title = $_POST['title'];
        $sender_email = $_POST['email'];

        // Validate inputs
        if (empty($message_text) || empty($message_title) || empty($sender_email)) {
            echo "One or more fields are empty!";
            exit;
        }

        try {
            // Insert message into the database
            $stmt = $pdo->prepare("INSERT INTO message (message_text, message_title, sender_email) VALUES (:message_text, :message_title, :sender_email)");
            $stmt->bindParam(':message_text', $message_text);
            $stmt->bindParam(':message_title', $message_title);
            $stmt->bindParam(':sender_email', $sender_email);
            $stmt->execute();

            // Return succesfull message
            echo "Message was sent successfully!";
        } catch (PDOException $e) {
            echo "Something went wrong, try again.";
        }

    // Handle Search Requests -------------------------------------------------------------------------------------
    } elseif ($action == 'search') {
        // Get the data from the form
        $keyword = $_POST['text'];

        // Validate inputs
        if (empty($keyword)) {
            echo "One or more fields are empty!";
            exit;
        }

        try {
            // Select all the products which have the string in their title or description
            $stmt = $pdo->prepare(
                "SELECT *
                FROM product
                JOIN category ON product.category_id = category.category_id
                WHERE product_name LIKE '%".$keyword."%'
                OR product_description LIKE '%".$keyword."%';"
            );
            $stmt->execute();
            $search_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            session_start();
            $_SESSION['search_products'] = $search_products;
           
        } catch (PDOException $e) { 
            echo 'Something is not alright!'. $e;
        }
    }
}

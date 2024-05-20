<?php
session_start();
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Include the navbar and sidemenu -->
    <?php include 'components/navbar.php'; ?>
    <?php include 'components/sideMenu.php'; ?>

    <div style="display: flex; flex-direction: column; width: 100%;">
        <section>
            <div class="account-wrapper">
                <div style="display: flex; flex-direction: row; align-items: center; width: 60%; justify-content: center;">
                    <?php

                    // Check if the user is logged in, otherwise don't show orders
                    if (!isset($_SESSION['email'])) {
                        echo 'You have to be logged in!';
                    } else {

                        // If user is logged in show the order form and orders
                        echo '
                            <div style="display: flex; flex-direction: column; width: 70%;">
                                <form id="orderForm" method="POST" style="display: flex; flex-direction: column;">
                                    <input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'">
                    
                                    <label for="address" style="padding-top: 30px;">Address:</label>
                                    <input type="address" id="address" name="address" required style="height: 60px;">
                    
                                    <label for="card" style="padding-top: 30px;">Card Number:</label>
                                    <input type="text" id="card" name="card" required style="height: 60px;">
                    
                                    <button type="submit" style="margin-top: 30px;">Place Order</button>
                                </form>
                            </div>

                            <div id="orderItems" style="padding-left: 15px; display: flex; flex-direction: column; max-height: 70vh; overflow-x: scroll;">
                            </div>
                        ';
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>

    <?php include 'components/footer.php'; ?>
</body>

<script>
    function generateCheckoutHTML() {
    // Retrieve cart items from the cookie
    let cartItems = getCartItems();

    // Referencing the sidemenuContent div, in which the cart items will be displayed based on the cart_items cookie
    const sidemenuContent = document.querySelector('#orderItems');

    // Clear all previous content of this div - this is helpfull for dynamically updating the div
    sidemenuContent.innerHTML = '';

    // Check to see if the content of the cart_items cookies is greater than 0
    if (cartItems.length > 0) {

        // Generate a list based on the cart items
        cartItems.forEach(item => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart_item');

            cartItem.innerHTML = `
       
            <div style="width: 100px;">
                <img src="assets/img/products/`+item['productName']+`.jpeg" style="width: 100%;"/>
            </div>
            <div style="display: flex; flex-direction: column;">
                <p style="font-size: 14px;">`+item['productName']+`</p>
                <p style="font-size: 14px; color: grey; margin: 0;">£`+item['productPrice']+`</p>
                <button style="width: 100px; margin-top: 10px; padding: 5px;" onclick="removeCartItem(`+item['productId']+`)">Remove</button>
            </div>

            `;
            sidemenuContent.appendChild(cartItem);
        });
    } else {

        // Display a message for when the  cart is empty
        sidemenuContent.innerHTML = `
            <p style="font-size: 14px; color: grey;">No products in cart.</p>
        `
        }
    }

    // Submittinng an order
    $(document).ready(function () {
        $("#orderForm").on('submit', function (event) {
            event.preventDefault();

            var formData = {};
            $(this).serializeArray().forEach(function(item) {
                formData[item.name] = item.value;
            });

            let cartItems = getCartItems();
            let product_ids = [];
            cartItems.forEach(item => {
                product_ids.push(parseInt(item['productId']));
            })
           
            $.ajax({
                type: "POST",
                url: "http://localhost:8888/backend/api.php", // The URL to the PHP file that processes the data
                data: {
                    user_id: formData["user_id"],
                    address: formData["address"],
                    card: formData["card"],
                    action: 'order',
                    products: product_ids
                },
                success: function (response) {

                    // Show a successful response
                    alert(response)

                    // Empty the cart_items cookie
                    document.cookie = "cart_items=" + JSON.stringify([]) + "; path=/";

                    // Redirect to the account page to see the new order
                    window.location.href = "http://localhost:8888/account.php";
                },
                error: function (xhr, status, error) {
                    alert(xhr);
                    console.error(xhr);
                }
            });
        });
    });

    generateCheckoutHTML();
</script>

</html>
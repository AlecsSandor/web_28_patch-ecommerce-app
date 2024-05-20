<?php
session_start();
?>
<div class="sidemenu-background" id='sideMenu'>
    <div class="sidemenu-wrapper">
        <div
            style="width: 100%; background-color: #e6e6e6; height: 80px; display: flex; flex-direction: row; align-items: center; justify-content: space-between; jutify-items: center;">
            <p style="padding-left: 20px; margin: 0; font-size: 14px;">Shopping Cart</p>
            <div style="padding-right: 20px; margin: 0; font-size: 20px; cursor: pointer;" onClick="toggleSideMenu()">✖
            </div>
        </div>
        <div class="sidemenu-content">

        </div>
        <div style="display: flex; flex-direction: column; width: 100%; padding: 30px;">
            <div style="display: flex; flex-direction: row; width: 100%; justify-content: space-between;">
                <p style="font-size: 14px;">Subtotal: </p>
                <p id="totalPrice" style="font-size: 14px;">£89</p>
            </div>
            <button
                onclick="goToCheckout('<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>')">Checkout</button>
        </div>
    </div>
</div>

<script>

    // Function to go to checkout - does a few checks first
    function goToCheckout(session) {
        let cartItems = getCartItems();
        if (cartItems.length === 0) {
            alert("Add some items in the cart first...")
        } else {
            if (session) {
                window.location.href = "http://localhost:8888/checkout.php";
            } else {
                alert("Login in order to proced to checkout!")
            }
        }
    }

    // Function to generate HTML for the cart - iterates over all the items in the cart_items cookie and renders their details
    function generateCartHTML() {
        // Retrieve cart items from the cookie
        let cartItems = getCartItems();

        // Referencing the sidemenuContent div, in which the cart items will be displayed based on the cart_items cookie
        const sidemenuContent = document.querySelector('.sidemenu-content');

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
                <img src="assets/img/products/`+ item['productName'] + `.jpeg" style="width: 100%;"/>
            </div>
            <div style="display: flex; flex-direction: column;">
                <p style="font-size: 14px;">`+ item['productName'] + `</p>
                <p style="font-size: 14px; color: grey; margin: 0;">£`+ item['productPrice'] + `</p>
                <button style="width: 100px; margin-top: 10px; padding: 5px;" onclick="removeCartItem(`+ item['productId'] + `)">Remove</button>
            </div>

            `;
                sidemenuContent.appendChild(cartItem);
            });
        } else {

            // Display a message for when the cart is empty
            sidemenuContent.innerHTML = `
            <p style="font-size: 14px; color: grey;">No products in cart.</p>
        `
        }
    }

    // Function to calculate the total price of the items in cart
    function getTotalPrice() {
        // Retrieve current cart items from the cookie
        let cartItems = getCartItems();

        let totalPrice = 0.0;

        for (let i = 0; i < cartItems.length; i++) {
            totalPrice = totalPrice + parseFloat(cartItems[i].productPrice)
        }

        // Update total price
        document.getElementById("totalPrice").innerHTML = totalPrice;

        // If total price is bigger than 0 add the red bubble next to the cart
        if (totalPrice > 0) {
            document.getElementById("cart_bubble").classList.add('cart-bubble');
        } else {
            document.getElementById("cart_bubble").classList.remove('cart-bubble');
        }
    }

    // Function to remove asingle item from cart - triggers whenn user clicks the remove button
    function removeCartItem(itemId) {

        // Retrieve current cart items from the cookie .
        let cartItems = getCartItems();

        // Iteratte through the items to find and delete the requested item.
        for (let i = 0; i < cartItems.length; i++) {
            if (cartItems[i].productId === parseInt(itemId)) {
                cartItems.splice(i, 1);
                break;
            }
        }

        // Update the cookie with the new cart items
        document.cookie = "cart_items=" + JSON.stringify(cartItems) + "; path=/";
        generateCartHTML();
        getTotalPrice();
        generateCheckoutHTML();
    }

    // Call the function to display cart items and totlal price whever the navbar is loaded
    generateCartHTML();
    getTotalPrice();
</script>
<div class="navbar-wrapper">
    <div class="navbar-inner">

        <p style = "
                padding-top: 2px;
                padding-bottom: 2px;
                text-decoration: none;
                color: #453029;
                font-size: 33px;
                font-weight: bold;
                margin: 15px;
            "
        >patch.</p>

        <div class="navbar-menu">
            <div class="navbar-menu-item desktop-menu">
                <a href="http://localhost:8888/home.php" class="navbar-menu-item-txt">HOME</a>
            </div>

            <div class="navbar-menu-item desktop-menu">
                <a href="http://localhost:8888/about.php" class="navbar-menu-item-txt">ABOUT</a>
            </div>

            <div class="navbar-menu-item desktop-menu">
                <a href="http://localhost:8888/contact.php" class="navbar-menu-item-txt">CONTACT</a>
            </div>

            <div class="navbar-menu-item desktop-menu">
                <a href="http://localhost:8888/products.php" class="navbar-menu-item-txt">PRODUCTS</a>
            </div>
            
            <div class="navbar-menu-item" onClick="navigateToAccount()">
                <img class="navbar-menu-icon" src="assets/img/user.png" alt="User">
            </div>

            <div class="navbar-menu-item" onclick="toggleSideMenu()">
                <img class="navbar-menu-icon" src="assets/img/cart.png" alt="Cart">
                <div id="cart_bubble"></div>
            </div>

            <div class="navbar-menu-item mobile-menu" onclick="toggleSideMenu()">
                <img class="navbar-menu-icon" src="assets/img/menu.png" alt="Menu">
            </div>
        </div>
        </div>
    </div>
</div>

<script src="assets/libraries/jquery_3.7.1.js"></script>
<script>

    // Function to show or hide  the side menu
    function toggleSideMenu() {
        var sideMenu = document.getElementById('sideMenu');
        if (sideMenu.style.display === 'block') {
            sideMenu.style.display = 'none'; // Hide the side menu
        } else {
            sideMenu.style.display = 'block'; // Show the side menu
        }
    }

    // Function to update the cart_items cookie with a new item
function updateCart(productId, productPrice, productName) {
 
    const item = { productId: productId, productPrice: productPrice, productName: productName };

    // Retrieve current cart items from the cookie .
    let cartItems = getCartItems();
    
    // Add the new item to the cart
    cartItems.push(item);

    // Update  the cookie with the new cart items
    document.cookie = "cart_items=" + JSON.stringify(cartItems) + "; path=/";
}

// Functionn to retrieve cart items from the cookie
function getCartItems() {
    let cookieString = document.cookie;
    let cookies = cookieString.split(';');
    let cartItems = [];

    // Find the cart_items cookie and get its contents
    cookies.forEach(cookie => {
        let [name, value] = cookie.split('=');
        if (name.trim() === 'cart_items') {
            cartItems = JSON.parse(decodeURIComponent(value));
        }
    });

    return cartItems;
}

    function navigateToAccount() {
        window.location.href = 'http://localhost:8888/account.php';
    }
  

</script>
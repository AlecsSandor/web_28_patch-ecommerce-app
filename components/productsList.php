
<div class="products_list_wrapper">
  <div class="products_list">
    <div class="products_inner">

    <?php 
      // Render the results from session variable
      if (isset($_SESSION['search_products'])) {
        foreach ($_SESSION['search_products'] as $product) { 
          ?>
            <div class="item_wrapper">
              <div class="item_img_wrapper">
                <p></p>
                <img src="assets/img/products/<?php echo $product["product_name"] ?>.jpeg" style="width:100%;" onclick="navigateToLink(<?php echo $product['product_id'] ?>)"/>
              </div>
              <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%; padding-top: 5px;">
                <p style="color: black; margin: 0px;"><?php echo $product["product_name"] ?></p>
                <p style="color: black; margin: 0px;">£<?php echo $product["product_price"] ?></p>
              </div>
              <div style="display: flex; flex-direction: row; align-items: left; width: 100%; padding-top: 5px; padding-bottom: 10px;">
                <p style="color: grey; margin: 0px;"><?php echo $product["category_title"] ?></p>
              </div>
              <button style="width: 100%;" class="general_button" onclick="addToCart(<?php echo $product['product_id']; ?>, <?php echo $product['product_price']; ?>, '<?php echo $product['product_name']; ?>')"
              >Add to Cart</button>
            </div>
          <?php
        }
      } elseif (isset($_SESSION['products'])) {
        foreach ($_SESSION['products'] as $product) { 
          ?>
            <div class="item_wrapper">
              <div class="item_img_wrapper">
                <p></p>
                <img src="assets/img/products/<?php echo $product["product_name"] ?>.jpeg" style="width:100%;" onclick="navigateToLink(<?php echo $product['product_id'] ?>)"/>
              </div>
              <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%; padding-top: 5px;">
                <p style="color: black; margin: 0px;"><?php echo $product["product_name"] ?></p>
                <p style="color: black; margin: 0px;">£<?php echo $product["product_price"] ?></p>
              </div>
              <div style="display: flex; flex-direction: row; align-items: left; width: 100%; padding-top: 5px; padding-bottom: 10px;">
                <p style="color: grey; margin: 0px;"><?php echo $product["category_title"] ?></p>
              </div>
              <button style="width: 100%;" class="general_button" onclick="addToCart(<?php echo $product['product_id']; ?>, <?php echo $product['product_price']; ?>, '<?php echo $product['product_name']; ?>')"
              >Add to Cart</button>
            </div>
          <?php
        }
      } else {
        echo "No products found.";
      }
      unset($_SESSION['search_products']);
    ?>

    </div>
  </div>
</div>

<script>
function navigateToLink(product_id) {
    window.location.href = "http://localhost:8888/product.php?pr="+ product_id +"";
}

// Add a new item to cart
function addToCart(productId, productPrice, productName) {

  // Run the updateCart method to add a new item to the cart_items cookie
  updateCart(productId, productPrice, productName);

  // Re- render the cart items - without having to refresh the entire page
  generateCartHTML();
  getTotalPrice();

  // Tell the user that a new item has been added to the cart
  alert("Item added to cart!")
}
</script>
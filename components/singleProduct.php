<div class="single-product-wrapper">
    <div class="single-product-inner">
        <div>
            <img src="assets/img/products/<?php echo $_SESSION['product'][0]['product_name'] ?>.jpeg" style="width:100%; flex: 1;"/> 
        </div>

        <div style="display: flex; flex-direction: column; align-items: left; flex: 1; padding-left: 60px; color: black;">
            <h1 style="margin-bottom: 0; font-weight: 300; font-size: 30px;"><?php echo $_SESSION['product'][0]['product_name'] ?></h1>
            <h3 style="margin-top: 0; font-weight: 200;"><?php echo $_SESSION['product'][0]['category_title'] ?></h3>
            <div style="border-top: 1px solid rgb(221, 221, 221); width: 100%; padding-top: 10px; padding-bottom: 10px;"> </div>
            <h2 style="font-weight: 500; font-size: 20px;">£<?php echo $_SESSION['product'][0]['product_price'] ?></h2>
            <div style="border-top: 1px solid rgb(221, 221, 221); width: 100%; padding-top: 10px; padding-bottom: 10px;" > </div>
            <p style="font-weight: 200; line-height: 2;"><?php echo $_SESSION['product'][0]['product_description'] ?></p>
            <button style="margin-top: 60px; width: 200px;">Add to Cart</button>
        </div>
    </div>
</div>
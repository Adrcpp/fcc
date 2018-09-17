
<div class="bg-black cart-empty">
    <div class="container p-4">
        <div class="text-center p-4">
            <h1 class="hero-title title-white title-home">Cart</h1>
            <h5 class="sub-title-cart pb-5">Your cart is still empty!</h5>
            <img src="https://www.adrien-cesaro.fr/wp-content/uploads/2018/08/empty_cart.png" />
        </div>
        <div class="text-center p-5">
            <a href="<?php echo home_url() . '/discover'?>"><div class="go-shop cart-btn"> Discover our cheeses</div></a>
        </div>
    </div>

</div>

<div class="mt-3 p-4">
    <?php  Widget_Social::render_widget(false); ?>
</div>

<div id="cart-image" class = "header-image">
  <div class="header-text">
    <h1>Checkout</h1>
  </div>
</div>
<main id = "order_page" ng-app = "listApp">
    <div class = "sidebar col-lg-3 col-md-3 col-sm-3"></div>
    <?php
        $macarons = [
            'chocolate' => ['title' => 'Chocolate', 'description' => 'This chocolaty decadent delight will melt in your mouth as you sink your teeth into chocolate nirvana.', 'price' => '$1.99'],
            'coconut' => ['title' => 'Coconut', 'description' => 'This coconutty decadent delight will melt in your mouth as you sink your teeth into coco nirvana.', 'price' => '$1.99'],
            'violet' => ['title' => 'Violet Cassis', 'description' => 'This violet decadent delight will melt in your mouth as you sink your teeth into purplish nirvana.', 'price' => '$1.99'],
            'green' => ['title' => 'Green Tea', 'description' => 'This green decadent delight will melt in your mouth as you sink your teeth into tea nirvana.', 'price' => '$1.99'],
            'passion' => ['title' => 'Passion Fruit', 'description' => 'This passiony decadent delight will melt in your moth as you sink your teeth into fruity nirvana.', 'price' => '$1.99'],
            'vanilla' => ['title' => 'Vanilla', 'description' => 'This vanilla decadent delight will melt in your mouth as you sink your teeth into smooth nirvana.', 'price' => '$1.99'],
            'coffee' => ['title' => 'Coffee', 'description' => 'This coffee decadent delight will melt in your mouth as you sink your teeth into twitchy nirvana.', 'price' => '$1.99'],
            'pistacio' => ['title' => 'Pistachio', 'description' => 'This pistacio decadent delight will melt in your mouth as you sink your teeth into nutty nirvana.', 'price' => '$1.99'],
            'raspberry' => ['title' => 'Raspberry', 'description' => 'This berry decadent delight will melt in your mouth as you sink your teeth into raspy nirvana.', 'price' => '$1.99'],
            'lemon' => ['title' => 'Raspberry', 'description' => 'This citrus decadent delight will melt in your mouth as you sink your teeth into lemonny nirvana.', 'price' => '$1.99'],
            'rose' => ['title' => 'Rose', 'description' => 'This decadent beauty of a delight will melt in your mouth as you sink your teeth into rosy nirvana.', 'price' => '$1.99'],
            'tiffany' => ['title' => 'Tiffany Blue', 'description' => 'This berry decadent delight will melt in your mouth as you sink your teeth into raspy nirvana.', 'price' => '$1.99'],
            'Caramel' => ['title' => 'Caramel', 'description' => 'This berry decadent delight will melt in your mouth as you sink your teeth into raspy nirvana.', 'price' => '$1.99'],
            'almond' => ['title' => 'Almond', 'description' => 'This berry decadent delight will melt in your mouth as you sink your teeth into raspy nirvana.', 'price' => '$1.99'],
        ];
    ?>
    <div class = "main_list col-lg-9 col-md-9 col-sm-9">
        <?php
            foreach ($macarons as $key => $value){
        ?>
        <div class = " list_item col-lg-12 col-md-12 col-sm-12">
            <h4><?php print $value['title']; ?></h4>
            <p><?php print $value['description']; ?></p>
        </div>
        <?php
            }
        print_r($_SESSION);
        ?>
    </div>
</main>

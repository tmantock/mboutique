<?php
  $flavors = [
    'Monday'=>['flavor'=>'Chocolate','img'=>'assets/images/chocolate-mac.png','description'=>'milk chocolatey'],
    'Tuesday'=>['flavor'=>'Cookies & Cream','img'=>'assets/images/cookies-mac.png','description'=>'dunkable'],
    'Wednesday'=>['flavor'=>'Strawberry','img'=>'assets/images/strawberry-mac.png','description'=>'fresh from the field'],
    'Thursday'=>['flavor'=>'Pistachio','img'=>'assets/images/pistachio-mac.png','description'=>'nutty'],
    'Friday'=>['flavor'=>'Coffee','img'=>'assets/images/truffee-mac.png','description'=>'addictive'],
    'Saturday'=>['flavor'=>'Caramel & Toffee','img'=>'h']
  ];

  $date = date("l");

  $currenct_flavor;
  $current_image;
  $description;

  foreach($flavors as $key => $value){
    if($key == $date){
      $currenct_flavor = $value['flavor'];
      $currenct_image = $value['img'];
    }
  }
?>
<!--Begin Image for Home Page-->
<div id="welcome-image" class = "header-image">
  <div class="header-text">
    <h1>MBoutique</h1>
  </div>
</div>
<main id = "main-container" class = "col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1" ng-controller="dateController as dc">
  <h2 class="shop-header">About Us</h2>
        <div id = "main-body-paragraph">
            <h3>Welcome to MBoutique!</h3>
            <p>We're a home based baking business that specializes in the making of French macarons, a gluten-free pastry item made from ground almonds. Our business began at the West Reading Farmers Market in 2011. Last year (2015) marked our third and final season of participation at the market. MBoutique was established to pay homage to the delicate French confectionery, the macaron. Our shop has been recognized as the connoisseurs of this delicious French pastry because of the wonderful variety of flavors from our great master chefs.</p>
            <h3>We love Macarons!</h3>
            <p>Renowned macarons, French delights of the moment can be met in a variety of flavors and colors and are brilliant precisely because of their simplicity - a crispy coating, but delicate in a loose blanket jam, chocolate butter cream is spread inviting.
                <br>
                <br>
                Macarons combines perfectly with champagne or white wine, tea or hot chocolate, fresh juices and natural fruit flavored coffee and guarantee that these little delights soon become friend that you can not break.</p>
            <h3>Find that flavor you like. Try our flavor of the day!</h3>
        </div>
    <!--Begin bottom dates block row-->
</main>
<article id="home-page" class="col-sm-12">
  <div class="left-home col-lg-7 col-md-7">
    <div class="left-box top-box col-lg-12 col-md-12">
      <div class="price-dispay price">
        <h3> {{ dc.flavor.cost | currency }} </h3>
      </div>
      <h1>It's {{ dc.flavor.day }}!</h1>
      <h1>The flavor of the day is {{ dc.flavor.name }}!</h1>
    </div>
    <div class="left-box bottom-box col-lg-12 col-md-12">
      <h2>Keep an eye out for these next!</h2>
      <table class="table">
        <thead>
          <tr>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td ng-repeat="day in dc.days">
              {{ day.name }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>

  <div class="right-home col-lg-5 col-md-5">
    <div class="right-card">
      <h2>Order Our "MBoutique Dozen" Now!</h2>
      <div class="price-dispay discount">
        <h3>15% Off</h3>
      </div>
      <div class="order-button">
        Order Now
      </div>
    </div>
  </div>
</article>

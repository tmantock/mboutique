<?php
  $flavors = [
    'Monday'=>['flavor'=>'Chocolate','img'=>'assets/images/chocolate-mac.png','description'=>'milk chocolatey'],
    'Tuesday'=>['flavor'=>'Cookies & Cream','img'=>'assets/images/cookies-mac.png','description'=>'dunkable'],
    'Wednesday'=>['flavor'=>'Strawberry','img'=>'assets/images/strawberry-mac.png','description'=>'fresh from the field'],
    'Thursday'=>['flavor'=>'Pistachio','img'=>'assets/images/pistachio-mac.png','description'=>'nutty'],
    'Friday'=>['flavor'=>'Coffee','img'=>'assets/images/truffee-mac.png','description'=>'addictive'],
    'Saturday'=>['flavor'=>'Caramel & Toffee']
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
<article id="home-page" class="col-sm-12">
  <div class="left-home col-lg-7 col-md-7">
    <div class="left-box top-box col-lg-12 col-md-12">
      <div class="price-dispay price">
        <h3>$4.99</h3>
      </div>
      <h1>It's {{ dc.date }}!</h1>
      <h1>The flavor of the day is <?=$currenct_flavor;?>!</h1>
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

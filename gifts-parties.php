<div id="gifts-image" class = "header-image">
  <div class="header-text">
    <h1>Gifts &amp; Parties</h1>
  </div>
</div>
<article id = "gifts" class = "col-sm-10 col-sm-offset-1">
    <h3>Macarons for Everyone!</h3>
    <p>We make it easy to share la passion du macaron with your friends, family and colleagues. Choose from our array of premium gift options, or we can create a custom solution. Contact us when you need help planning your celebration! <a href ="#">orders@mboutique.com</a></p>
    <h2 class="shop-header">Gift boxes</h2>
    <div class="gift-container col-lg-12 col-md-12 col-xs-12">

      <div class="macaron-container col-lg-4 col-md-4 col-xs-6" ng-repeat="gift in macarons | filter: {category: '3'}">
        <div class="price-dispay price"><h3>{{ gift.cost | currency }}</h3></div>
        <img class="shop-image" ng-src="{{ gift.img_src }}">
        <h4>{{ gift.name }}</h4>
        <div class="shop-controls col-sm-12">
          <div class="add-cart col-sm-6 col-sm-offset-3" ng-click="addToggle = !addToggle" ng-hide="addToggle">Add to Cart</div>
          <div class="cart-controls col-sm-6 col-sm-offset-3" ng-show="addToggle">
            <button ng-click="pc.giftCartControl(gift,0,$index);" type="button" class="btn button-macaron col-sm-3">-</button>
            <div class="display-count col-sm-6">{{ gift.count }}</div>
            <button ng-click="pc.giftCartControl(gift,1,$index);" type="button" class="btn button-macaron col-sm-3">+</button>
          </div>
        </div>
      </div>
    </div>

    <h2 class="shop-header">Of Course We Cater!</h2>

    <div class="catering-container col-lg-12 col-md-12 col-xs-12">
      <div class = "catering-left col-lg-6 col-md-6">
        <div class="catering-top col-sm-12 mdl-shadow--2dp">

        </div>
        <div class="catering-bottom col-sm-12 mdl-shadow--2dp">

        </div>
      </div>
      <div class = "catering-right col-lg-6 col-md-6">
        <div class = "catering-box-right col-sm-12 mdl-shadow--2dp">

        </div>
      </div>
    </div>

</article>

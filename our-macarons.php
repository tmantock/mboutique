<div id="shop-image" class = "header-image">
  <div class="header-text">
    <h1>Shop</h1>
  </div>
</div>
<article id = "macarons-shop" class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-12">
  <h3>Our macarons are freshly made by hand</h3>
  <p>The vivid hues of our unique macarons reflect the natural flavors and essences {{ date }} that infuse the ganache filling of these delicious almond cookies - each has its own personality, and all of them are made to savour for their delicacy and unique character. Take a look around to find your next guilty pleasure.</p>
  <h2 class="shop-header">Shop</h2>
  <div class="shop-container col-lg-12 col-md-12 col-xs-12">
    <div class="macaron-container col-lg-4 col-md-4 col-xs-6" ng-repeat="macaron in macarons | filter: {category: '1'}">
      <div class="price-dispay price"><h3>{{ macaron.cost | currency }}</h3></div>
      <img class="shop-image" ng-src="{{ macaron.img_src }}">
      <h4>{{ macaron.name }}</h4>
      <div class="shop-controls col-sm-12">
        <div class="add-cart col-sm-8 col-sm-offset-2" ng-click="addToggle = !addToggle" ng-hide="addToggle">Add to Cart</div>
        <div class="cart-controls col-sm-8 col-sm-offset-2" ng-show="addToggle">
          <button ng-click="sc.macaronCartControl(macaron,0,$index);" type="button" class="btn button-macaron col-sm-3">-</button>
          <div class="display-count col-sm-6">{{ macaron.count }}</div>
          <button ng-click="sc.macaronCartControl(macaron,1,$index);" type="button" class="btn button-macaron col-sm-3">+</button>
        </div>
      </div>
    </div>
  </div>
  <!-- <p id = "second-paragraph">After purchase we recommend keeping macarons in the refrigerator; let them come to room temperature before serving - about 10 minutes. For best degestation, our macarons should be consumed within 3 days.</p> -->
</article>

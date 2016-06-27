<div id="shop-image" class = "header-image">
  <div class="header-text">
    <h1>Shop</h1>
  </div>
</div>
<article id = "macarons-shop" class="col-sm-12">
  <h2>Our macarons are freshly made by hand</h2>
  <p>The vivid hues of our unique macarons reflect the natural flavors and essences {{ date }} that infuse the ganache filling of these delicious almond cookies - each has its own personality, and all of them are made to savour for their delicacy and unique character. Take a look around to find your next guilty pleasure.</p>
  <h2 class="shop-header">Shop</h2>
  <div class="shop-container col-lg-12 col-md-12 col-xs-12">
    <div class="col-lg-4 col-md-4 col-xs-12" ng-repeat="macaron in macarons | filter: {category: '1'}">
      <div class="col-sm-12 mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title" image-background value= "{{macaron.img_src}}">
          <h2 class="mdl-card__title-text"> {{ macaron.name }} </h2>
        </div>
        <div class="mdl-card__supporting-text"> {{ macaron.description }} </div>
        <div class="mdl-card__actions mdl-card--border">
          <a class="cart-control mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" ng-click="toggleControls = !toggleControls">
            Add To Cart
          </a>
          <div class="cart-buttons" ng-show="toggleControls">
            <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect"ng-click="sc.macaronCartControl(macaron,0,$index)">
              -
            </a>
            <a>{{ macaron.count }} </a>
            <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" ng-click="sc.macaronCartControl(macaron,1,$index)">
              +
            </a>
          </div>
        </div>
        <div class="mdl-card__menu">
          <h2 class = "price"> {{ macaron.cost | currency }} </h2>
        </div>
      </div>
      </div>
  </div>
  <!-- <p id = "second-paragraph">After purchase we recommend keeping macarons in the refrigerator; let them come to room temperature before serving - about 10 minutes. For best degestation, our macarons should be consumed within 3 days.</p> -->
</article>

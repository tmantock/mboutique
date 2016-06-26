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

      <div class="col-lg-3 col-md-3 mdl-card mdl-shadow--2dp" ng-repeat="gift in macarons | filter: {category: '3'}">
        <div class="mdl-card__title" image-background value= "{{gift.img_src}}">
          <h2 class="mdl-card__title-text"> {{ gift.name }} </h2>
        </div>
        <div class="mdl-card__supporting-text"> {{ gift.description }} </div>
        <div class="mdl-card__actions mdl-card--border">
          <a class="cart-control mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" ng-click="toggleControls = !toggleControls">
            Add To Cart
          </a>
          <div class="cart-buttons" ng-show="toggleControls">
            <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect"ng-click="pc.giftCartControl(gift,0,$index)">
              -
            </a>
            <a>{{ gift.count }} </a>
            <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" ng-click="pc.giftCartControl(gift,1,$index)">
              +
            </a>
          </div>
        </div>
        <div class="mdl-card__menu">
          <div class="macaron-price-dispay">
            <h3> {{ gift.cost | currency }} </h3>
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

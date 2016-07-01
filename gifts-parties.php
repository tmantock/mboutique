<div id="gifts-image" class = "header-image">
  <div class="header-text">
    <h1>Gifts &amp; Parties</h1>
  </div>
</div>
<article id = "gifts" class = "col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-12 body">
    <h2>Macarons for Everyone!</h2>
    <p>We make it easy to share la passion du macaron with your friends, family and colleagues. Choose from our array of premium gift options, or we can create a custom solution. Contact us when you need help planning your celebration! <a href ="#">orders@mboutique.com</a></p>
    <h2 class="shop-header">Gift boxes</h2>
    <div class="gift-container col-sm-12">
      <div class="col-lg-4 col-md-4 col-xs-12 card" ng-repeat="gift in macarons | filter: {category: '3'}">
      <div class="col-lg-12 col-md-12 col-xs-12 mdl-card mdl-shadow--2dp">
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
            <h2 class = "price"> {{ gift.cost | currency }} </h2>
        </div>
      </div>
      </div>
    </div>

    <h2 class="shop-header">Of Course We Cater!</h2>

    <div class="catering-container col-lg-12 col-md-12 col-xs-12">
      <div class = "catering-left col-lg-6 col-md-6 col-xs-12">
        <div class="catering-top col-sm-12 mdl-shadow--2dp">

        </div>
        <div class="catering-bottom col-sm-12 mdl-shadow--2dp">

        </div>
      </div>
      <div class = "catering-right col-lg-6 col-md-6 col-xs-12">
        <div class = "catering-box-right col-sm-12 mdl-shadow--2dp">

        </div>
      </div>
    </div>

</article>

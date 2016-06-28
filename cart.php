<div id="cart-image" class = "header-image">
  <div class="header-text">
    <h1>Checkout</h1>
  </div>
</div>
<main id = "order_page">
    <div class = "sidebar col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-12" ng-show="displayToggle">
      <button type="button" class="btn btn-info col-xs-12 display-toggle" ng-click="displayToggle = !displayToggle">Show Cart</button>
      <div class = "choose-checkout" ng-hide="showGuest || showSignUp || showSignIn;">
        <button type="button" class="btn btn-primary col-xs-12" ng-click="showSignUp = !showSignUp">Sign-Up</button>
        <button type="button" class="btn btn-info col-xs-12" ng-click="showSignIn = !showSignIn">Sign-In</button>
        <button type="button" class="btn btn-success col-xs-12" ng-click="showGuest = !showGuest">Guest Checkout</button>
      </div>
      <div class = "checkout_form col-sm-12 mdl-shadow--2dp">
        <sign-up ng-show="showSignUp"></sign-up>
        <sign-in ng-show="showSignIn"></sign-in>
        <guest-checkout ng-show="showGuest"></guest-checkout>
      </div>

    </div>

    <div class = "cart_list col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-xs-12 " ng-hide="displayToggle">
      <div class="col-sm-12 checkout-bar-container">
        <div class="checkout-bar col-sm-4">
          <h3>Items: {{ cart }}</h3>
        </div>
        <div class="checkout-bar col-sm-4">
          <h3>Total: {{ total | currency}}</h3>
        </div>
        <div class="checkout-bar col-sm-4">
          <button type="button" class="btn btn-success col-sm-12 display-toggle" ng-click="displayToggle = !displayToggle">Checkout</button>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-12 card" ng-repeat="item in checkout">
      <div class="col-sm-12 mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title" image-background value= "{{item.img_src}}">
          <h2 class="mdl-card__title-text"> {{ item.name }} - {{ item.count }}</h2>
        </div>
        <div class="mdl-card__supporting-text"> {{ item.description }} </div>
        <div class="mdl-card__actions mdl-card--border">
          <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
            Remove
          </a>
        </div>
        <div class="mdl-card__menu">
            <h2 class="price">{{ item.count * item.cost | currency }}</h2>
        </div>
      </div>
            </div>
    </div>
</main>

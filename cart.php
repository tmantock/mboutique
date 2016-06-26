<div id="cart-image" class = "header-image">
  <div class="header-text">
    <h1>Checkout</h1>
  </div>
</div>
<main id = "order_page">
    <div class = "sidebar col-lg-3 col-md-3 col-sm-3">
      <div class = "checkout_form col-sm-12 mdl-shadow--2dp">
        <form class="form-horizontal">
  <fieldset>
    <legend>Checkout</legend>
    <div class="form-group">
      <label for="inputName" class="col-lg-3 control-label">Name</label>
      <div class="col-lg-9">
        <input type="text" class="form-control" id="inputName" placeholder="Full Name">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-3 control-label">Email</label>
      <div class="col-lg-9">
        <input type="email" class="form-control" id="inputEmail" placeholder="Email Address">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPhone" class="col-lg-3 control-label">Phone</label>
      <div class="col-lg-9">
        <input type="text" class="form-control" id="inputPhone" placeholder="Phone Number">
      </div>
    </div>
    <div class="form-group">
      <label for="inputAddress" class="col-lg-3 control-label">Address</label>
      <div class="col-lg-9">
        <input type="text" class="form-control" id="inputAddress" placeholder="Street Address">
      </div>
    </div>
    <div class="form-group">
      <label for="inputCity" class="col-lg-3 control-label">City</label>
      <div class="col-lg-9">
        <input type="text" class="form-control" id="inputCity" placeholder="City">
      </div>
    </div>
    <div class="form-group">
      <label for="inputZip" class="col-lg-3 control-label">Zip</label>
      <div class="col-lg-9">
        <input type="text" class="form-control" id="inputZip" placeholder="Zip Code">
      </div>
    </div>
    <div class="form-group">
      <label for="state" class="col-lg-3 control-label">State</label>
      <div class="col-lg-9">
        <select class="form-control" id="state">
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="checkoutComments" class="col-lg-3 control-label">Textarea</label>
      <div class="col-lg-9">
        <textarea class="form-control" rows="3" id="checkoutComments"></textarea>
        <span class="help-block">Please leave any comments here.</span>
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
</form>
      </div>

    </div>

    <div class = "cart_list col-lg-9 col-md-9 col-sm-9">
      <div class="col-sm-6 mdl-card mdl-shadow--2dp" ng-repeat="item in checkout">
        <div class="mdl-card__title" image-background value= "{{item.img_src}}">
          <h2 class="mdl-card__title-text"> {{ item.name }} </h2>
        </div>
        <div class="mdl-card__supporting-text"> {{ item.description }} </div>
        <div class="mdl-card__actions mdl-card--border">
          <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
            Remove
          </a>
        </div>
        <div class="mdl-card__menu">
          <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
            <i class="material-icons">share</i>
          </button>
        </div>
      </div>
    </div>
</main>

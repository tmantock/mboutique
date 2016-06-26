<?php
date_default_timezone_set('America/Los_Angeles');
?>
<div id="map" class = "header-image">
  <div class="header-text">
    <h1>Contact Us</h1>
  </div>
</div>
<article id = "contacts" class="col-sm-12">
    <div id = "days-address" class = 'col-md-4 col-sm-12'>
        <h3 class="move-right">Visit us!</h3>
        <ul>
            <li>Monday - Friday | 10am - 9pm</li>
            <li>Saturday | 10am - 8pm</li>
            <li>Sunday | 11am - 7pm</li>
            <li>Closed Thanksgiving Day,
            Christmas Day,<br>
            and Easter Day</li>
        </ul>

        <p class="move-right">1625 Post St<br>San Francisco, CA 94115</p>

        <p class="move-right">949 800-3111</p>

        <a href = "#" class="move-right">order@mboutique.com</a>

        <p class="move-right">Send your questions, comments and flavor<br>suggestions or place an order</p>
    </div>
    <div id = "contact-form" class = 'col-md-4 col-sm-12'>
      <fieldset>
        <h3>Have Any Quetsions?</h3>
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
          <div class="form-group">
            <label for="inputSubject" class="col-lg-3 control-label">Subject</label>
            <div class="col-lg-9">
              <input type="text" class="form-control" id="inputSubject" placeholder="Phone Number">
            </div>
          </div>
          <div class="form-group">
            <label for="contactComments" class="col-lg-3 control-label">Textarea</label>
            <div class="col-lg-9">
              <textarea class="form-control" rows="3" id="conctactComments"></textarea>
              <span class="help-block">Please leave your message here.</span>
            </div>
            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button type="reset" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="col-sm-4 map-container">
        <div id="map"></div>
    </div>
</article>

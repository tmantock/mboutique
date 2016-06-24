<?php
session_start();

    function holiday_date_check() {
        $current_date = date("m/d");
        $holidays = [
            '05/26' => 'css/newyear.css',
            '07/04' => 'css/july4th.css',
            '12/25' => 'css/christmas.css'
        ];
        $current_css = null;
        if(!empty($holidays[$current_date])){
            $extra_css_link = "<link href ='{$holidays[$current_date]}' rel='stylesheet' type='text/css'>";
        } else{
            $extra_css_link = '';
        }
        print($extra_css_link);
    }
    holiday_date_check();
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <title>Welcome</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- Angular -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
    <!-- Angular Routing -->
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-route.min.js"></script>
    <!-- Roboto  Font -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body ng-app="mboutiqueApp">
    <!--Begin Navigation Bar-->
    <nav id = 'navbar' class = "navbar navbar-fixed-top">
    <div class = 'container-fluid'>
        <div class = 'navbar-header'>
            <button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navbar-collapse">
                <span class = "icon-bar"></span>
                <span class = "icon-bar"></span>
                <span class = "icon-bar"></span>
            </button>
            <a class = 'navbar-brand' id = 'brand'> <img id = "logo-image" src = "./assets/images/logo.png"></a>
        </div>
        <div class = 'navbar-collapse collapse navbar-collapse'>
            <ul class = 'nav navbar-nav navbar-right'>
              <li><a class="n_link" href="#welcome">WELCOME</a></li>
              <li><a class="n_link" href="#macarons">OUR MACARONS</a></li>
              <li><a class="n_link" href="#gifts">GIFTS &amp; PARTIES</a></li>
              <li><a class="n_link" href="#cart">CART</a></li>
              <li><a class="n_link" href="#contact">CONTACT</a></li>
            </ul>
      </div>
    </nav>

    <!--ng-view -->
    <div id="content" ng-controller="mainController">
        <div ng-view></div>
    </div>

    <footer class = "col-sm-12 col-xs-12">
        <ul>
            <li><img src = "./assets/images/mail.png" class = "icons">order@mboutique.com</li>
            <li><img src ="./assets/images/phone.png" class = "icons">949-800-3111</li>
            <li>Follow us:<img src = "./assets/images/facebook.png" class = "icons" id = "facebook"><img src= "./assets/images/twitter.png" class = "icons"></li>
        </ul>
        <p>Copyright &copy; 2015 MBoutique. All rights reserved</p>
    </footer>
    <!-- Modules -->
    <script src="js/app.js"></script>
    <!-- Services -->
    <script src="js/services/macaronRetrieve.js"></script>
    <!-- Controllers -->
    <script src="js/controllers/dateController.js"></script>
    <script src="js/controllers/cartController.js"></script>
    <script src="js/controllers/contactController.js"></script>
    <script src="js/controllers/partyController.js"></script>
    <script src="js/controllers/shopController.js"></script>
</body>

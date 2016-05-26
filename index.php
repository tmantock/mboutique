<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <title>Welcome</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css">
    <?php
    function holiday_date_check() {
        $current_date = date("m/d");

        $holidays = [
            '01/01' => 'newyear.css',
            '07/04' => 'july4th.css',
            '12/25' => 'christmas.css'
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
</head>
<body>
    <!--Begin Navigation Bar-->
    <nav>
        <img id = "logo-image" src = "./assets/images/logo.png">
        <?php
        $menu = [
            'home' => ['url' => 'home.php', 'link' => 'Welcome'],
            'our-macarons' => ['url' => 'our-macarons.php', 'link' => 'Our Macarons'],
            'gift_parties' => ['url' => 'gift_parties.php', 'link' => 'Gift & Parties'],
            'contact' => ['url' => 'contact.php', 'link' => 'Contact']
        ];
        ?>
        <ul>
            <?php
            foreach ($menu as $key=>$value) {
                ?>
                <li><a href="?page=<?= $key; ?>"><?= $value['link']; ?></a></li>
                <?php
            }
            ?>
        </ul>
    </nav>
    
    <!--Begin PHP Include -->

    <?php
        if(empty($_GET['page'])) {
            $_GET['page'] = 'home';
        }
        else{
            if(empty($_GET['page'])){
                $_GET['page'] = '404';
            }

        }
        $page = ($menu[$_GET['page']]['url']);

        require($page);
    ?>
    
    <footer class = "col-md-12 col-sm-12">
        <ul>
            <li><img src = "./assets/images/mail.png" class = "icons">order@mboutique.com</li>
            <li><img src ="./assets/images/phone.png" class = "icons">949-800-3111</li>
            <li>Follow us:<img src = "./assets/images/facebook.png" class = "icons" id = "facebook"><img src= "./assets/images/twitter.png" class = "icons"></li>
        </ul>
        <p>Copyright &copy 2015 MBoutique. All rights reserved</p>
    </footer>

</body>
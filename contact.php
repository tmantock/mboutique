<?php
date_default_timezone_set('America/Los_Angeles');
?>
<img src = "./assets/images/contact-image.png " class = "header-image">
<article id = "contacts">
    <div id = "days-address" class = 'col-md-4 col-sm-12'>
        <h3>Visit us!</h3>
        <ul>
            <li>Monday - Friday | 10am - 9pm</li>
            <li>Saturday | 10am - 8pm</li>
            <li>Sunday | 11am - 7pm</li>
            <li>Closed Thanksgiving Day, Christmas Day and Easter Day</li>
        </ul>

        <p>1625 Post St<br>San Francisco, CA 94115</p>

        <p>949 800-3111</p>

        <a href = "#">order@mboutique.com</a>

        <p>Send your questions, comments and flavor<br>suggestions or place an order</p>
    </div>
    <div id = "contact-form" class = 'col-md-4 col-sm-12'>
        <h3>Contact Form</h3>
        <form>
            <input type="text" id="name" placeholder="Name"><br>
            <input type="text" id="email" placeholder="Email"><br>
            <input type="text" id = "phone" placeholder="Name"><br>
            <input type = "text" id ="subject" placeholder="Subject"><br>
            <input type="text" id ="message" placeholder="Message">
            <input id="button" type="submit" value="Send">
        </form>
    </div>
    <?php
    function image_holiday_change ()
    {
        $current_date = date('m/d');

        $holiday_image = [
            '01/01' => './assets/images/new-years-macaron.jpg',
            '07/04' => './assets/images/home-july-4th.jpg',
            '05/26' => './assets/images/christmas-macaron.jpg'
        ];
        if (!empty($holiday_image[$current_date])) {
            $img = $holiday_image[$current_date];
        } else {
            $img = "./assets/images/macarons-image.png";
        }
        ?>
        <div id="macaron-image" class='col-md-4 col-sm-12'><img src="<?=$img?>"></div>
        <?php
    }
    image_holiday_change();
    ?>
</article>

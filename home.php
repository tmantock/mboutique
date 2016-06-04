
    <!--Begin Image for Home Page-->
    <img src = "./assets/images/welcome-image.png" id = "home-image">
    <!--Begin Image and Intro Paragraph Section-->
    <div id = "main-container" class = "col-md-12">
        <div class = 'row-1'>
            <div id = "left-macaron-image" class = "col-md-3 col-sm-12">
                <?php
                    function image_holiday_change ()
                    {
                        $current_date = date('m/d');

                        $holiday_image = [
                            '01/01' => './assets/images/new-years-macaron.jpg',
                            '07/04' => './assets/images/home-july-4th.jpg',
                            '12/25' => './assets/images/christmas-macaron.jpg'
                        ];
                        if (!empty($holiday_image[$current_date])) {
                            $img = $holiday_image[$current_date];
                        }
                        else  {
                            $img = "./assets/images/macarons-image.png";
                        }
                        ?>
                        <img src="<?php print($img);?>">
                        <?php
                    }
                image_holiday_change();
                ?>
            </div>
            <div id = "main-body-paragraph" class = "col-md-9 col-sm-12">
                <h3>Welcome to MBoutique!</h3>
                <p>We're a home based baking business that specializes in the making of French macarons, a gluten-free pastry item made from ground almonds. Our business began at teh West Reading Farmers Market in 2011. Last year (2013) marked our third and final season of participation at the market. MBoutique was established to pay homage to the delicate French confectionery, the macaron. Our shop has been recognized as the connoisseurs of this delicious French pastry because of teh wonderful variety of flavors from our great master chefs.</p>
                <h3>We love Macarons!</h3>
                <p>Renowned macarons, French delights of the moment can be met in a variety of flavors and colors and are brilliant precisely because of their simplicity - a crispy coating, but delicate in a loose blanket jam, chocolate butter cream is spread inviting.
                    <br>
                    <br>
                    Macarons combines perfectly with champagne or white wine, tea or hot chocolate, fresh juices and natural fruit flavored coffee and guarantee that these little delights soon become friend that you can not break.</p>
                <h3>Find that flavor you like. Try a sample every day!</h3>
            </div>
        </div>
        <!--Begin bottom dates block row-->
        <div id = "dates-container" class = 'col-md-12'>
            <div class = "col-md-2  col-sm-12" id = "monday-block">
                <p>Monday
                    <br>
                    <br>
                    15:00-16:00</p>
                <div class = "col-sm-12" id = "chocolate-flavor">
                    <div class = "col-md-7">chocolate</div>
                    <div class = "col-md-5"><img src = "./assets/images/chocolate.png"></div>
                </div>
                <div class = "col-sm-12" id = "coconut-flavor">
                    <div class = "col-md-7">coconut</div>
                    <div class = "col-md-5"><img src = "./assets/images/coconut.png"></div>
                </div>
            </div>
            <div class = "col-md-2 col-sm-12" id = "tuesday-block">
                <p>Tuesday
                    <br>
                    <br>
                    14:00-15:00</p>
                <div class = "col-sm-12" id = "cassis-flavor">
                    <div class = "col-md-7">violet cassis</div>
                    <div class = "col-md-5"><img src = "./assets/images/violet-cassis.png"></div>
                </div>
                <div class = "col-sm-12" id = "green-flavor">
                    <div class = "col-md-7">green tea</div>
                    <div class = "col-md-5"><img src = "./assets/images/green-tea.png"></div>
                </div>
            </div>
            <div class = "col-md-2 col-sm-12" id = "wednesday-block">
                <p>Wednesday
                    <br>
                    <br>
                    09:00-10:00</p>
                <div class = "col-sm-12" id = "passion-flavor">
                    <div class = "col-md-7">passion fruit</div>
                    <div class = "col-md-5"><img src = "./assets/images/passion-fruit.png"></div>
                </div>
                <div class = "col-sm-12" id = "vanilla-flavor">
                    <div class = "col-md-7">vanilla</div>
                    <div class = "col-md-5"><img src = "./assets/images/vanilla.png"></div>
                </div>
            </div>
            <div class = "col-md-2 col-sm-12" id = "thursday-block">
                <p>Thursday
                    <br>
                    <br>
                    18:00-19:00</p>
                <div class = "col-sm-12" id = "coffee-flavor">
                    <div class = "col-md-7">coffee</div>
                    <div class = "col-md-5"><img src = "./assets/images/coffee.png"></div>
                </div>
                <div class = "col-sm-12" id = "pistachio-flavor">
                    <div class = "col-md-7">pistachio</div>
                    <div class = "col-md-5"><img src = "./assets/images/pistachio.png"></div>
                </div>
            </div>
            <div class = "col-md-2 col-sm-12" id = "friday-block">
                <p>Friday
                    <br>
                    <br>
                    11:00-12:00</p>
                <div class = col-sm-12 id = "raspberry-flavor">
                    <div class = "col-md-7">raspberry</div>
                    <div class = "col-md-5"><img src = "./assets/images/raspbery.png"></div>
                </div>
                <div class = "col-sm-12" id = "lemon-flavor">
                    <div class = "col-md-7">lemon</div>
                    <div class = "col-md-5"><img src = "./assets/images/lemon.png"></div>
                </div>
            </div>
            <div class = "col-md-2 col-sm-12" id = "saturday-block">
                <p>Saturday
                    <br>
                    <br>
                    13:00-14:00</p>
                <div class = "col-sm-12" id = "rose-flavor">
                    <div class = "col-md-7">rose</div>
                    <div class = "col-md-5"><img src = "./assets/images/rose.png"></div>
                </div>
                <div class = "col-sm-12" id = "tiffany-flavor">
                    <div class = "col-md-7">tiffany blue</div>
                    <div class = "col-md-5"><img src = "./assets/images/tiffany-blue.png"></div>
                </div>
            </div>
            <div class = "col-md-2 col-sm-12" id = "sunday-block">
                <p>Sunday
                    <br>
                    <br>
                    10:00-11:00</p>
                <div class = "col-sm-12" id = "caramel-flavor">
                    <div class = "col-md-7">caramel</div>
                    <div class = "col-md-5"><img src = "./assets/images/caramel.png"></div>
                </div>
                <div class = "col-sm-12" id = "almond-flavor">
                    <div class = "col-md-7">almond</div>
                    <div class = "col-md-5"><img src = "./assets/images/almond.png"></div>
                </div>
            </div>
        </div>
    </div>
    <!--Begin Footer section-->

    

    
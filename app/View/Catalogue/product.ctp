<section id="main">
    <div class="body-text">
        <div class="container-fluid">
            <!-- 2 columns -->
            <div class="row-fluid">
                <div class="span6">
                    <p><img src="<?php echo $this->webroot . "uploads/product/" . $data['featured'][0]; ?>"></p>
                </div>
                <div class="span6">
                    <h3><strong>BILLY RAYS</strong> <span style="text-transform: uppercase;"><?php echo $data['name']; ?></span></h3>
                    <hr class="black">
                    <p class="asking-price"><span>$<?php echo $data['price']; ?></span> Free international shipping</p>
                    <hr class="black">
                    <div data-lstyle="case_description" data-l="case_description" class="case-desc case_description" style="height:200px;overflow: auto;"><?php echo $data['description']; ?></div>
                    <hr class="black"><br>

                    <button class="btn btn-danger">Add To Cart</button>

                    <div class="social_wrapper">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style ">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_pinterest_pinit"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                        </div>
                        <script type="text/javascript">var addthis_config = {"data_track_addressbar": true};</script>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51937361798a0638"></script>
                        <!-- AddThis Button END -->
                    </div>


                    <div class="thumwrapper">
                        <?php foreach ($data['featured'] as $image) : ?>
                        <img src="<?php echo $this->webroot . "uploads/product/" . $image; ?>">
                        <?php endforeach; ?>
                    </div>
                </div>			
            </div>
            <!--end 2 columns-->
            <!-- start row-rluid demo -->
            <div class="row-fluid demo">

                <!-- end .row-fluid -->	
            </div>
            <!-- end .row-fluid demo -->
        </div>
        <!-- end container-fluid-->
    </div>
    <!-- end body-text -->
</section>


<!-- /container -->
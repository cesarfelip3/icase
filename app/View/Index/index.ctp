<!-- Slider start-->
 

<!-- end slider -->		 
<!-- single column -->
<div class="clear:both;"></div>
<div class="row-fluid">
    <div class="span9 fullwide">
        <div class="row-fluid">
            <h1 style="color:orange">Best Sell of the week</h1>
        </div>
        <div class="row-fluid hotproperties">
            <?php if (!empty ($data)) : ?>
            <?php foreach ($data as $value) : ?>
            <div class="span4 set-equal-heights-js">
                <div class="thumbnail">
                    <a href="<?php echo $this->webroot . "product/" . $value['Product']['slug']; ?>"><img src="<?php echo $this->webroot . "uploads/product/" . $value['Product']['featured']['150w'][0]; ?>" alt="Placeholder" class=""></a>
                    <div class="caption">
                        <a href="property.html" class="prop-title" style="text-transform: uppercase;"><?php echo $value['Product']['name']; ?></a>
                        <p class="price">$<?php echo $value['Product']['price']; ?></p>
                        <ul class="list-btns">
                            <li><a href="<?php echo $this->webroot . "product/" . $value['Product']['slug']; ?>">View Details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
<!--            <div class="span4 set-equal-heights-js">
                <div class="thumbnail">
                    <a href="property.html"><img src="http://www.casetagram.com/usr/7705/217705/221463.png.240x240.png" alt="Placeholder" class=""></a>
                    <div class="caption">
                        <a href="property.html" class="prop-title">Property Name, Toronto ON</a>
                        <p class="price">$259,000</p>
                        <ul class="list-btns">
                            <li><button class="btn btn-small btn-inverse colwhite"><a href="property.html">View Details</a></button></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="span4 set-equal-heights-js">
                <div class="thumbnail">
                    <a href="property.html"><img src="http://www.casetagram.com/usr/7705/217705/221463.png.240x240.png" alt="Placeholder" class=""></a>
                    <div class="caption">
                        <a href="property.html" class="prop-title">Property Name, Toronto ON</a>
                        <p class="price">$259,000</p>
                        <ul class="list-btns">
                            <li><button class="btn btn-small btn-inverse colwhite"><a href="property.html">View Details</a></button></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="span4 set-equal-heights-js">
                <div class="thumbnail">
                    <a href="property.html"><img src="http://www.casetagram.com/usr/7705/217705/221463.png.240x240.png" alt="Placeholder" class=""></a>
                    <div class="caption">
                        <a href="property.html" class="prop-title">Property Name, Toronto ON</a>
                        <p class="price">$259,000</p>
                        <ul class="list-btns">
                            <li><button class="btn btn-small btn-inverse colwhite"><a href="property.html">View Details</a></button></li>
                        </ul>
                    </div>
                </div>
            </div>-->
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <h1></h1>
        <p class="body-paragraph">
            <span class="signature"></span>
        </p>
    </div>
</div>
</div>
<!--end single column-->

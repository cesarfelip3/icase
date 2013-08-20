<!-- Slider start-->
 

<!-- end slider -->		 
<!-- single column -->
<div class="clear:both;"></div>
<div class="row-fluid">
    <div class="span9 fullwide">
	

	
	<div class="banner"><img src="<?php echo $this->webroot . "img/banner.jpg" ?>" alt="Placeholder" class=""></div>
	<div class="threestep">
		<h2>3 steps <span>to create your case</span></h2>
		
		
		<a href="#"><div class="stepone"><b>choose</b><br>a case</div></a>
		<a href="#"><div class="steptwo"><b>upload </b><br>your image</div></a>
		<a href="#"><div class="stepthree"><b>We print</b><br>high quality</div></a>
		
	</div>
        <div class="row-fluid">
            <h1 class="title">FEATURE PRODUCTS</h1>
        </div>
        <div class="row-fluid hotproperties">
            <?php if (!empty ($data)) : ?>
            <?php foreach ($data as $value) : ?>
            <div class="span4 set-equal-heights-js">
                <div class="thumbnail">
                    <a class="thumimg" href="<?php echo $this->webroot . "product/" . $value['Product']['slug']; ?>"><img src="<?php echo $this->webroot . "uploads/product/" . $value['Product']['featured']['150w'][0]; ?>" alt="Placeholder" class=""></a>
                    <div class="caption">
                        <a href="property.html" class="prop-title" style="text-transform: uppercase;"><?php echo $value['Product']['name']; ?></a>
                        <p class="price">$<?php echo $value['Product']['price']; ?></p>
                        <ul class="list-btns">
                            <li ><a class="buynow" href="<?php echo $this->webroot . "product/" . $value['Product']['slug']; ?>">View Details</a></li>
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

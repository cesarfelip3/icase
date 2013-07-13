		<section id="main">
			<div class="body-text">
				<div class="container-fluid">
					<div class="row-fluid">
						<div class="span3 hidden-phone">
				         	
				            <!-- Upload image -->
				        	<div class="qbox">
				            	<h3><i class="icon-eye-open pull-right"></i>Upload image</h3>
				                <p>Register your criteria and Property Alert will let you know when properties are listed.</p>
				                <div>
				                	<form class="image-upload">
										<fieldset>

										<!-- image upload -->

										<!-- File Button --> 
										<div class="control-group">
										  <label class="control-label" for="img-upload"></label>
										  <div class="controls">
										    <input id="img-upload" name="img-upload" class="input-file" type="file">
										  </div>
										</div>
										</fieldset>
										</form>
									<img src='http://placehold.it/148x129/E37F14/FFFFFF' alt='Placeholder Image'>	
				                    <button class="btn btn-small">Add to Canvas</button>
				                </div>
				            </div>
				            <!-- end zone alert -->
				            <!-- add text -->
				            <div class="qbox">
				            	<h3><i class="icon-eye-open pull-right"></i>Free drawing</h3>
				           <button id="singlebutton" name="singlebutton" class="btn btn-default">Enter Drawing mode</button>
				            </div>




						</div>
						<div class="span6 listing-js">
							
							<!-- page title with dropdown -->
							<h1>Create Your Case</h1>
							<div class="container-fluid">
								<div class="row-fluid">
									<div class="span7 dropdown-results">
										<p>Select Your Device:</p>
									</div>
									<div class="span5">
										<select id="sort" name="sort">
											<option value="iphone5">Iphone 5</option>
											<option value="iphone4">Iphone 4/4S</option>
											<option value="ipad">Ipad</option>
											<option value="ipad-mine">Ipad Mine</option>
										</select>
									</div>
								</div>
							</div>
							<!-- end page title -->
							
							<!--start Canvas-->
							<canvas class="upper-canvas " style="border: 1px solid rgb(170, 170, 170); width: 453px; height: 500px; left: 0px; top: 0px; -moz-user-select: none; cursor: crosshair;" width="500" height="500"></canvas>							
							<!--end Canvas-->	
							<button id="singlebutton" name="singlebutton" class="btn btn-info">Add Text</button>
							<button id="singlebutton" name="singlebutton" class="btn btn-danger">Clear Canvas</button><br><br>

							<!-- Form Name -->
<!-- Textarea -->
<div class="control-group">
  
  <div class="controls">                     
    <textarea id="textarea" name="textarea">Enter your text</textarea>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="selectbasic">Font</label>
  <div class="controls">
    <select id="selectbasic" name="selectbasic" class="input-large">
      <option>Helvitica</option>
      <option>Arial</option>
      <option>Verdana</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="selectbasic">Text Align</label>
  <div class="controls">
    <select id="selectbasic" name="selectbasic" class="input-xlarge">
      <option>Left</option>
      <option>Right</option>
      <option>Center</option>
    </select>
  </div>
</div>
</form>		
						
							
														
							
						
						</div>
						<!-- end listing-js -->
						
						<div class="span3">
							<!--
								"Quick Search" Widget
								
								SPECIAL NOTE: Please leave the inline style for <Select></Select> "width:100%",
											  the width is automatically "Re-adjusted" with javascript
											  See "config.js" for more details	
							-->
							<p><button class="btn btn-large btn-peach">Order Now</button></p>
							<div class="qbox">

				            	<h3><i class="icon-search pull-right"></i>Filters</h3>
								<form>
									<!-- Multiple Checkboxes -->
										<div class="control-group">
										  <label class="control-label" for="checkboxes"></label>
										  <div class="controls">
										    <label class="checkbox" for="checkboxes-0">
										      <input type="checkbox" name="checkboxes" id="checkboxes-0" value="Grayscale:">
										      Grayscale
										    </label>
										    <label class="checkbox" for="checkboxes-1">
										      <input type="checkbox" name="checkboxes" id="checkboxes-1" value="Invert:">
										      Invert
										    </label>
										    <label class="checkbox" for="checkboxes-2">
										      <input type="checkbox" name="checkboxes" id="checkboxes-2" value="Sepia:">
										      Sepia
										    </label>

										    <label class="checkbox" for="checkboxes-3">
										      <input type="checkbox" name="checkboxes" id="checkboxes-3" value="Sepia2:">
										      Sepia2
										    </label>

										      <label class="checkbox" for="checkboxes-0">
										      <input type="checkbox" name="checkboxes" id="checkboxes-0" value="Grayscale:">
										      Blur
										    </label>
										    <label class="checkbox" for="checkboxes-1">
										      <input type="checkbox" name="checkboxes" id="checkboxes-1" value="Invert:">
										      Sharpen
										    </label>
										    <label class="checkbox" for="checkboxes-2">
										      <input type="checkbox" name="checkboxes" id="checkboxes-2" value="Sepia:">
										      Emboss:
										    </label>

										    <label class="checkbox" for="checkboxes-3">
										      <input type="checkbox" name="checkboxes" id="checkboxes-3" value="Sepia2:">
										      Waterize:
										    </label>






										    <label class="checkbox" for="checkboxes-4">
										      <input type="checkbox" name="checkboxes" id="checkboxes-4" value="Remove white:">
										      Remove white:
										    </label>
										    <label>Distance: <input type="range" id="remove-white-distance" value="10" min="0" max="255"></label>


										     <label class="checkbox" for="checkboxes-5">
										      <input type="checkbox" name="checkboxes" id="checkboxes-5" value="Remove-white">
										      Brightness:
										    </label>
										    <label>Value: <input type="range" id="remove-white-distance" value="10" min="0" max="255"></label>

										     <label class="checkbox" for="checkboxes-6">
										      <input type="checkbox" name="checkboxes" id="checkboxes-6" value="Noise">
										      Noise:
										    </label>
										    <label>Value: <input type="range" id="remove-white-distance" value="10" min="0" max="255"></label>


										    <label class="checkbox" for="checkboxes-7">
										      <input type="checkbox" name="checkboxes" id="checkboxes-7" value="GradientTransparency">
										      GradientTransparency:
										    </label>
										    <label>Value: <input type="range" id="gradientTransparency" value="10" min="0" max="255"></label>

										    <label class="checkbox" for="checkboxes-7">
										      <input type="checkbox" name="checkboxes" id="checkboxes-7" value="Pixelate">
										      Pixelate:
										    </label>
										    <label>Value: <input type="range" id="Pixelate" value="10" min="0" max="255"></label>

										    <label>Amplitude: <input type="range" id="Amplitude" value="10" min="0" max="255"></label>
										    <label>Frequency: <input type="range" id="Frequency" value="10" min="0" max="255"></label>
										    <label>Offset: <input type="range" id="Offset" value="10" min="0" max="255"></label>








										  </div>


										</div>             	
				                				                    
				                   



				                   
				                </form>
				
				            </div>								                	
				                	
				                	
				                    
				                </div>
				       	 	</div>
				       	 	<!--/end my short list-->
						</div>
						<!-- end span3 -->					
					</div>
					<!-- end row-fluid -->
				</div>
				<!-- end fluid-container -->
			</div>
			<!-- end body-text -->
		</section>
		<!-- end section -->
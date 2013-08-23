<style tyle="text/css">
    a.title {text-decoration: none;color:orange}
    .form-horizontal label.control-label {width:80px;}
    .form-horizontal .controls {margin-left:120px;}
</style>
<div class='row-fluid'>
    <div class='span3'>
        <div class="well" id="box-category" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding-top:5px">
            <h3 style="border-bottom:1px solid #ccc">My Dashboard</h3>
            <ul class="nav nav-list">
                <li><a href="<?php echo $this->webroot; ?>user/">Dashboard</a></li>
                <li><a href="<?php echo $this->webroot; ?>creation/">Creations</a></li>
                <li><a href="<?php echo $this->webroot; ?>order/">Orders</a></li>
                <li class="active"><a href="<?php echo $this->webroot; ?>user/profile">Profile</a></li>
            </ul>
        </div>
    </div>
    <div class='span8'>
        <div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
            <form class="form-horizontal" id="form-new" style="background:none;padding-top:0px;margin-top:0px;">
                <div>
                    <div style="padding:10px;">
                        <h2 style="border-bottom:1px solid #ccc;padding:5px;">Account Info</h2>
                    </div>
                    <fieldset>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">User Name</label>
                            <div class="controls">
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[name]" value="<?php echo $data['name']; ?>" readonly='readonly' >
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Email</label>
                            <div class="controls">
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[email]" value="<?php echo $data['email']; ?>" >
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Password</label>
                            <div class="controls">
                                <input class="input-medium focused" id="focusedInput" type="password" name="user[password]" >
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div style="padding:10px;">
                            <h2 style="border-bottom:1px solid #ccc;padding:5px;">Default Deliver Info</h2>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Name</label>
                            <div class="controls">
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[firstname]" placeholder="First name"  value="<?php echo $data['firstname']; ?>">
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[lastname]" placeholder="Last name"  value="<?php echo $data['lastname']; ?>">
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Email</label>
                            <div class="controls">
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[email2]" placeholder="Email"  value="<?php echo $data['email2']; ?>">
                                <span class="help-inline">Notify your order status</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Phone</label>
                            <div class="controls">
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[phone]" placeholder="Phone" value="<?php echo $data['phone']; ?>">
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Location</label>
                            <div class="controls">
                                <input class="input-small focused" id="focusedInput" type="text" name="user[country]" placeholder="Country" value='US' readonly="readonly" >
                                <select name="user[state]" class="input-medium" id="sel-state">
                                    <option value="" selected="selected">Select A State</option> 
                                    <option value="AL">Alabama</option> 
                                    <option value="AK">Alaska</option> 
                                    <option value="AZ">Arizona</option> 
                                    <option value="AR">Arkansas</option> 
                                    <option value="CA">California</option> 
                                    <option value="CO">Colorado</option> 
                                    <option value="CT">Connecticut</option> 
                                    <option value="DE">Delaware</option> 
                                    <option value="DC">District Of Columbia</option> 
                                    <option value="FL">Florida</option> 
                                    <option value="GA">Georgia</option> 
                                    <option value="HI">Hawaii</option> 
                                    <option value="ID">Idaho</option> 
                                    <option value="IL">Illinois</option> 
                                    <option value="IN">Indiana</option> 
                                    <option value="IA">Iowa</option> 
                                    <option value="KS">Kansas</option> 
                                    <option value="KY">Kentucky</option> 
                                    <option value="LA">Louisiana</option> 
                                    <option value="ME">Maine</option> 
                                    <option value="MD">Maryland</option> 
                                    <option value="MA">Massachusetts</option> 
                                    <option value="MI">Michigan</option> 
                                    <option value="MN">Minnesota</option> 
                                    <option value="MS">Mississippi</option> 
                                    <option value="MO">Missouri</option> 
                                    <option value="MT">Montana</option> 
                                    <option value="NE">Nebraska</option> 
                                    <option value="NV">Nevada</option> 
                                    <option value="NH">New Hampshire</option> 
                                    <option value="NJ">New Jersey</option> 
                                    <option value="NM">New Mexico</option> 
                                    <option value="NY">New York</option> 
                                    <option value="NC">North Carolina</option> 
                                    <option value="ND">North Dakota</option> 
                                    <option value="OH">Ohio</option> 
                                    <option value="OK">Oklahoma</option> 
                                    <option value="OR">Oregon</option> 
                                    <option value="PA">Pennsylvania</option> 
                                    <option value="RI">Rhode Island</option> 
                                    <option value="SC">South Carolina</option> 
                                    <option value="SD">South Dakota</option> 
                                    <option value="TN">Tennessee</option> 
                                    <option value="TX">Texas</option> 
                                    <option value="UT">Utah</option> 
                                    <option value="VT">Vermont</option> 
                                    <option value="VA">Virginia</option> 
                                    <option value="WA">Washington</option> 
                                    <option value="WV">West Virginia</option> 
                                    <option value="WI">Wisconsin</option> 
                                    <option value="WY">Wyoming</option>
                                </select>
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[city]" placeholder="City" value="<?php echo $data['city']; ?>" >
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Address</label>
                            <div class="controls">
                                <textarea name="user[address]"> <?php echo $data['address']; ?></textarea>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Zip code</label>
                            <div class="controls">
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[zipcode]" placeholder="Zip code" value="<?php echo $data['zipcode']; ?>" >
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group warning">
                            <label class="control-label" for="inputWarning"></label>
                            <div class="controls">
                                <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="user_profile_save();" id="btn-save">Save</a>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready (
        function () {
            <?php if (!empty($data['state'])) : ?>
            $("#sel-state").val ("<?php echo $data['state']; ?>");
            <?php endif; ?>
    });
    
    function user_profile_save () {
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>user/profile/",
            data: $("#form-new").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            
            var result = $.parseJSON(data);
            console.log(result);
            if (result.error == 1) {
                console.log(result.element);
                $(result.element).next(".help-inline").html(result.message);
                $(result.element).parent().parent().addClass('error');
                //showAlert(result.message);
            } else {
                window.location.href="";
            }
        }).fail(function() {

        });
    }
</script>
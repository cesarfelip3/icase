<style tyle="text/css">
    a.title {text-decoration: none;color:orange}
</style>
<div class='row-fluid'>
    <div class='span3'>
        <div class="well" id="box-category" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding-top:5px">
            <h3 style="border-bottom:1px solid #ccc">My Dashboard</h3>
            <ul class="nav nav-list">
                <li><a href="<?php echo $this->webroot; ?>user/">Dashboard</a></li>
                <li><a href="<?php echo $this->webroot; ?>user/order">Orders</a></li>
                <li><a href="<?php echo $this->webroot; ?>user/creation">Creations</a></li>
                <li class="active"><a href="<?php echo $this->webroot; ?>user/profile">Profile</a></li>
            </ul>
        </div>
    </div>
    <div class='span8'>
        <div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
            <form class="form-horizontal" id="form-new" style="background:none;">
                <div class="slate">
                    <div class="page-header">
                        <h2>Your profile</h2>
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
                        <div class="control-group">
                            <label class="control-label" for="optionsCheckbox2">Active</label>
                            <div class="controls">
                                <label class="checkbox">
                                    <input type="checkbox" id="optionsCheckbox2" name="user[active]" value="1" checked="checked">
                                    Yes
                                    <span class="help-inline"></span>
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="optionsCheckbox2">Type</label>
                            <div class="controls">
                                <input type="text" class="input-small" readonly="readonly" value="<?php echo $data['type']; ?>" />
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div>
                            <h3>Default Deliver Info</h3>
                            <hr/>
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
                            <label class="control-label" for="focusedInput">Phone</label>
                            <div class="controls">
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[phone]" placeholder="Phone" value="<?php echo $data['phone']; ?>">
                                <span class="help-inline"></span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="focusedInput">Location</label>
                            <div class="controls">
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[country]" placeholder="Country" value='US' >
                                <input class="input-medium focused" id="focusedInput" type="text" name="user[state]" placeholder="State" value="<?php echo $data['state']; ?>" >
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
                                <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('create');" id="btn-save">Save</a>
                                <span class="help-inline"></span>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>
    </div>
</div>
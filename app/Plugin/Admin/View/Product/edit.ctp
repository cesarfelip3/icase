<?php
$admin_home = $base;
$admin_product = $base . "product";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $admin_home; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">
                <a href="<?php echo $admin_product; ?>">Products</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Add</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <div class="alert alert-info hide">
            <a class="close" data-dismiss="alert" href="#">x</a>
            <h4 class="alert-heading">Information</h4>
        </div>
        <div class="row">
            <div class="span12">
                <div class="slate">
                    <div class="page-header">
                        <h2>New Product</h2>
                    </div>
                    <form class="form-horizontal">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" value="This is focused…">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <span class="input-xlarge uneditable-input">Some value here</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Disabled input</label>
                                <div class="controls">
                                    <input class="input-xlarge disabled" id="disabledInput" type="text" placeholder="Disabled input here…" disabled>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Disabled checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" value="option1" disabled>
                                        This is a disabled checkbox
                                    </label>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Input with warning</label>
                                <div class="controls">
                                    <input type="text" id="inputWarning">
                                    <span class="help-inline">Something may have gone wrong</span>
                                </div>
                            </div>
                            <div class="control-group error">
                                <label class="control-label" for="inputError">Input with error</label>
                                <div class="controls">
                                    <input type="text" id="inputError">
                                    <span class="help-inline">Please correct the error</span>
                                </div>
                            </div>
                            <div class="control-group success">
                                <label class="control-label" for="inputSuccess">Input with success</label>
                                <div class="controls">
                                    <input type="text" id="inputSuccess">
                                    <span class="help-inline">Woohoo!</span>
                                </div>
                            </div>
                            <div class="control-group success">
                                <label class="control-label" for="selectError">Select with success</label>
                                <div class="controls">
                                    <select id="selectError">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                    <span class="help-inline">Woohoo!</span>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
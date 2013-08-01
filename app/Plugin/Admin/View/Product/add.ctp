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
            <div class="span8">
                <div class="slate">
                    <div class="page-header">
                        <h2>New Product</h2>
                    </div>
                    <form class="form-horizontal" id="form-new">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="product[name]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Description</label>
                                <div class="controls">
                                    <textarea class="ckeditor" cols="80" id="editor1" name="product[description]" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Template</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="product[type]" value="template">
                                        Yes
                                    </label>
                                    <a href="#" class="btn btn-success">Template Image From Computer</a>
                                    <span class="label label-warning">For design only</span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Price</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[price]" placeholder="xxxx.xx">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Tax</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[tax]" value="0.00">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning" >Discount</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[discount]" value="0">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning" >Quantity</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[quantity]" value="0">
                                    <span class="help-inline">0 means unlimited</span>
                                </div>
                            </div>
                            <div class="control-group error">
                                <label class="control-label" for="inputError"></label>
                                <div class="controls">
                                    <a href="#" class="btn btn-success">Featured Images From Computer</a>
                                    <span class="label label-warning">For madeup case only</span>
                                </div>
                            </div>
                            <div class="page-header">
                                <h3>Special Offer</h3>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Special</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="product[is_special]">
                                        Yes
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Start Date</label>
                                <div class="controls">
                                    <input type="text" class="datepicker input-small" name="product[special_start]"/>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">End Date</label>
                                <div class="controls">
                                    <input type="text" class="datepicker input-small" name="product[special_end]" />
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Price</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="product[special_price]" placeholder="xxxx.xx">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning"></label>
                                <div class="controls">
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save();" id="btn-save">Save</a>
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save();" id="btn-publish">Publish</a>
                                </div>
                            </div>
                            <div class='well'>
                                <p>If "Special" is checked, the sale will start in duration, and use special price, when it's end, it will go back to the original price. All special offers will be on the top of the home product page, to promote sales.</p>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="span4">
                <div class="slate" id='box-category'>
                    <div class="page-header">
                        <h2>Category</h2>
                    </div>
                    <div class='body'>

                    </div>
                </div>
                <div class="slate">
                    <div class="page-header" id='box-template-image'>
                        <h2>Template Image</h2>
                    </div>
                </div>
                <div class="slate">
                    <div class="page-header" id='box-featured-images'>
                        <h2>Featured Images</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="navbar navbar-fixed-bottom hide">
    <div class="navbar-inner">
        <div class="container" style="width: auto; padding: 0 20px;">
            <a class="brand" href="#">Title</a>
            <ul class="nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Link</a></li>
                <li><a href="#">Link</a></li>
            </ul>
        </div>
    </div>
</div>
<script type='text/javascript'>
    $(document).ready(
        function() {
            jQuery.ajax({
                url: "<?php echo $base; ?>product/category/?action=checkbox",
                type: "GET",
                beforeSend: function(xhr) {
                }
            }).done(function(data) {
                jQuery("#box-category .body").html(data);

            }).fail(function() {
            });
        })

    function save() {
        jQuery.ajax({
            url: "<?php echo $base; ?>product/add",
            data: $("#form-new").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-save").button('loading');
            }
        }).done(function(data) {
            $("#btn-save").button('reset');

            var result = $.parseJSON(data);
            console.log(result);
            if (result.error == 1) {
                console.log(result.element);
                $(result.element).next(".help-inline").html(result.message);
                $(result.element).parent().parent().addClass('error');
                showAlert(result.message);
            } else {
                $(result.element).parent().parent().removeClass('error');
                $(result.element).next(".help-inline").html("");
            }

        }).fail(function() {
        });
    }
</script>
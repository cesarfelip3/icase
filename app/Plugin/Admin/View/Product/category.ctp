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
            <div class="span6">
                <div class="slate">
                    <div class="page-header">
                        <h2>New Category</h2>
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
                                    <textarea name="product[description]" style="width:280px" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Parent</label>
                                <div class="controls">
                                    <input type="text" class="input-medium" name="product[price]" placeholder="parent">
                                    <span class="help-inline"></span>
                                    <a href="javascript:" class="btn btn-success">Save</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="span6">
                <div class="slate" id='box-category'>
                    <div class="page-header">
                        <h2>Category</h2>
                    </div>
                    <div class='body'>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    $(document).ready (
        function () {
    
       
        jQuery.ajax({
            url: "<?php echo $base; ?>product/category",
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            jQuery("#box-category .body").html(data);

        }).fail(function() {
        }); 
    })
    
    function save () {
        jQuery.ajax({
            url: "<?php echo $base; ?>product/add",
            data: $("#form-new").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-save").button('loading');
            }
        }).done(function(data) {
            $("#btn-save").button('reset');
            
            var result = $.parseJSON (data);
            console.log (result);
            if (result.error == 1) {
                console.log (result.element);
                $(result.element).next(".help-inline").html (result.message);
                $(result.element).parent().parent().addClass('error');
                showAlert (result.message);
            } else {
                $(result.element).parent().parent().removeClass('error');
                $(result.element).next(".help-inline").html ("");
            }

        }).fail(function() {
        }); 
    }
</script>
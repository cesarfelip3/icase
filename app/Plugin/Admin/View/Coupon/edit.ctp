<?php
$admin_home = $base;
$admin_coupon = $base . "coupon";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $admin_home; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">
                <a href="<?php echo $admin_coupon; ?>">Coupons</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <form class="form-horizontal" id="form-new">
            <input type="hidden" name="coupon[featured]" value="" />
            <input type="hidden" name="coupon[image]" value="" />
            <input type="hidden" name="coupon[id]" value='' />
            <input type="hidden" name="coupon[guid]" value='' />
            <div class="alert alert-info hide">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <h4 class="alert-heading">Information</h4>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="slate">
                        <div class="page-header">
                            <h2>Edit Coupon</h2>
                        </div>
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="coupon[name]" value="<?php echo $data['name']; ?>" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Description</label>
                                <div class="controls">
                                    <textarea class="ckeditor" cols="80" id="editor1" name="coupon[description]" rows="10"><?php echo $data['description']; ?></textarea>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning" >Expired</label>
                                <div class="controls">
                                    <input type="text" class="input-small datepicker" name="coupon[expired]" readonly="readonly" value="<?php echo date("Y-m-d", $data['expired']); ?>">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Value</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="coupon[value]" placeholder="xxxx.xx" value="<?php echo $data['value']; ?>">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning" >Discount</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="coupon[discount]" value="<?php echo intval($data['discount']); ?>">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning" >Quantity</label>
                                <div class="controls">
                                    <input type="text" class="input-mini" name="coupon[quantity]"  value="<?php echo $data['quantity']; ?>">
                                    <span class="help-inline">65535 means unlimited</span>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Save Option</label>
                                <div class="controls">
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('create');" id="btn-save">Update</a>
<!--                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('update');" id="btn-save">Update</a>-->
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="span4">
                       
                </div>
            </div>
        </form>
    </div>
</div>
<!-- -->
<script type='text/javascript'>
    $(document).ready(
            function() {
                jQuery.ajax({
                    url: "<?php echo $base; ?>category/?action=checkbox",
                    type: "GET",
                    beforeSend: function(xhr) {
                    }
                }).done(function(data) {
                    jQuery("#box-category .body").html(data);
                    $("#form-new").serialize();

                }).fail(function() {
                });
            }
    );

    function save(action) {

        CKEDITOR.instances.editor1.updateElement();
        jQuery.ajax({
            url: "<?php echo $base; ?>coupon/edit/?id=<?php echo $data['guid']; ?>",
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
                window.location.href="<?php echo $this->webroot . "admin/coupon/"; ?>";
            }

        }).fail(function() {
        });
    }
</script>
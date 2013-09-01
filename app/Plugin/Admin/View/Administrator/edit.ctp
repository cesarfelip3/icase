<?php
$action_home = $base;
$action_administrator = $base . "administrator";
$action_add = $base . "administrator/add/";
$action_edit = $base . "administrator/edit/";
$action_order_fetch = $base . "order/fetch/";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $action_home; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">
                <a href="<?php echo $action_administrator; ?>">Administrators</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Edit</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <form class="form-horizontal" id="form-new">
            <input type="hidden" name="user[featured]" value="" />
            <input type="hidden" name="user[image]" value="" />
            <input type="hidden" name="user[guid]" value='' />
            <div class="alert alert-info hide">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <h4 class="alert-heading">Information</h4>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="slate">
                        <div class="page-header">
                            <h2>Edit Administrator</h2>
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
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning"></label>
                                <div class="controls">
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('create');" id="btn-save">Save</a>
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="span4">
                    <div class="slate" id='box-orders'>
                    </div>
                </div>
            </div>
        </form>
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
<!-- -->
<script type='text/javascript'>
    $(document).ready(
            function() {
                
            }
    );

    function save(action) {

        jQuery.ajax({
            url: "<?php echo $action_edit; ?>?action=" + action,
            data: $("#form-new").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-save").button('loading');
            }
        }).done(function(data) {
            $("#btn-save").button('reset');

            var result = $.parseJSON(data);
            if (result.error == 1) {
                $(".help-inline").html("");
                $(result.element).next(".help-inline").html(result.message);
                $(result.element).parent().parent().addClass('error');
                showAlert(result.message);
            } else {
                //window.location.href = "";
            }

        }).fail(function() {
        });
    }
    
    function order_load (id) {

        jQuery.ajax({
            url: "<?php echo $action_order_fetch; ?>?action=user&id=" + id,
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            $("#box-orders .body").html (data);

        }).fail(function() {
        });
    }
</script>
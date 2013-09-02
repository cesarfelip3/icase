<?php
$action_admin_index = $base;
$action_index = $base . "administrator";
$action_add = $base . "administrator/add/";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $action_admin_index; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">
                <a href="<?php echo $action_index; ?>">Administrators</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Add</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <form class="form-horizontal" id="form-new">
            <input type="hidden" name="data[featured]" value="" />
            <input type="hidden" name="data[image]" value="" />
            <input type="hidden" name="data[guid]" value='' />
            <div class="alert alert-info hide">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <h4 class="alert-heading">Information</h4>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="slate">
                        <div class="page-header">
                            <h2>New Administrator</h2>
                        </div>
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-medium focused" id="focusedInput" type="text" name="data[name]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Email</label>
                                <div class="controls">
                                    <input class="input-medium focused" id="focusedInput" type="text" name="data[email]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Password</label>
                                <div class="controls">
                                    <input class="input-medium focused" id="focusedInput" type="password" name="data[password]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Active</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="data[active]" value="1" checked="checked">
                                        Yes
                                        <span class="help-inline"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning"></label>
                                <div class="controls">
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save('create');" id="btn-save">Create</a>
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
            url: "<?php echo $action_add; ?>?action=" + action,
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
                window.location.href="";
            }

        }).fail(function() {
        });
    }
</script>
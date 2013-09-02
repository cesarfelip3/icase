<?php
$action_admin_index = $base;
$action_index = $base . "member";
$action_add = $base . "member/add/";
$action_edit = $base . "member/edit/";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $action_admin_index; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">
                <a href="<?php echo $action_index; ?>">Customers</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Add</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <form class="form-horizontal" id="form-data">
            <div class="alert alert-info hide">
                <a class="close" data-dismiss="alert" href="#">x</a>
                <h4 class="alert-heading">Information</h4>
            </div>
            <div class="row">
                <div class="span8">
                    <div class="slate">
                        <div class="page-header">
                            <h2>New Customer</h2>
                        </div>
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-large focused" id="focusedInput" type="text" name="form[name]" placeholder="lowercase and number only">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Email</label>
                                <div class="controls">
                                    <input class="input-large focused" id="focusedInput" type="text" name="form[email]" placeholder="example@gmail.com">
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Password</label>
                                <div class="controls">
                                    <input class="input-large focused" id="focusedInput" type="password" name="form[password]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Active</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" name="form[active]" value="1" checked="checked">
                                        Yes
                                        <span class="help-inline"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning"></label>
                                <div class="controls">
                                    <a href='javascript:' class='btn btn-primary' data-loading-text="Saving..." onclick="save();" id="btn-save">Create</a>
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

    function save() {

        jQuery.ajax({
            url: "<?php echo $action_add; ?>",
            data: $("#form-data").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-save").button('loading');
            }
        }).done(function(data) {
            $("#btn-save").button('reset');

            var result = $.parseJSON(data);
            if (result.error == 1) {
//                $(".help-inline").html("");
//                $(result.element).next(".help-inline").html(result.message);
//                $(result.element).parent().parent().addClass('error');
                showAlert(result.message);
            } else {
                window.location.href="<?php echo $action_index; ?>";
            }

        }).fail(function() {
        });
    }
</script>
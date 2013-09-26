<?php
$admin_home = $base;
$admin_product = $base . "product";
?>
<style>
    div.control-group label.control-label {
        width:60px;
    }
    
    form.form-horizontal div.controls {
        margin-left:100px;
    }
</style>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $admin_home; ?>">Admin</a> 
                <span class="divider">/</span>
            </li>
            <li class="active">Manage Industries</li>
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
            <div class="span5">
                <div class="slate" id='box-industry'>
                    <div class="page-header">
                        <h2>Industries<a class="btn btn-primary pull-right" id="btn-add">Add New</a><a class="btn btn-primary pull-right" id="btn-edit" style="margin-right:5px;">Edit</a></h2>
                    </div>
                    <div class='body' style="height:500px;overflow: auto;">
                    </div>
                </div>
            </div>
            <div class="span7 hide" id="box-new">
                <div class="slate">
                    <div class="page-header">
                        <h2>New Industry</h2>
                    </div>
                    <form class="form-horizontal" id="form-new">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="industry[name]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">URL Key</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="industry[slug]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">SEO</label>
                                <div class="controls">
                                    <p><input class="input-xlarge focused" id="focusedInput" type="text" name="industry[seo_keywords]" placeholder="keywords" ></p>
                                    <p><textarea name="industry[seo_description]" style="width:280px" rows="3" placeholder="description"></textarea></p>
                                    <a href="javascript:" class="btn btn-success" data-loading-text="Saving..." onclick="save('add');" id="btn-save">Create</a>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Parent</label>
                                <div class="controls">
                                    <input type="text" class="input-medium" name="industry[parent]" placeholder="Parent industry" readonly="readonly">
                                    <input type="hidden" class="input-medium" name="industry[parent_guid]">
                                    <span class="help-inline"></span>
                                    <a href="javascript:" class="btn btn-success" onclick="industry_clear();" id="btn-clear">Clear</a>
                                </div>
                            </div>
                            <hr/>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning"></label>
                                <div class="controls">
                                    <a href="javascript:" class="btn btn-info" onclick="industry_empty_table();">Empty All</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="span7" id="box-edit">
                <div class="slate">
                    <div class="page-header">
                        <h2>Edit Industry</h2>
                    </div>
                    <form class="form-horizontal" id="form-edit">
                        <input type="hidden" name="industry[guid]" />
                        <input type='hidden' name='industry[id]' />
                        <input type='hidden' name='industry[group_guid]' />
                        <input type='hidden' name='industry[parent_guid]' />
                        <input type='hidden' name='industry[level]' />
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="industry[name]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">URL Key</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="industry[slug]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">SEO</label>
                                <div class="controls">
                                    <p><input class="input-xlarge focused" id="focusedInput" type="text" name="industry[seo_keywords]" placeholder="keywords" ></p>
                                    <p><textarea name="industry[seo_description]" style="width:280px" rows="3" placeholder="description"></textarea></p>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Order</label>
                                <div class="controls">
                                    <input type="text" name="industry[order]" class='input-mini' />
                                    <span class="help-inline"></span>
                                    <a href="javascript:" class="btn btn-success" data-loading-text="Updating..." onclick="save('edit', this);" id="btn-update">Update</a>
                                    <a href="javascript:" class="btn btn-success" data-loading-text="Deleting..." onclick="save('delete', this);" id="btn-update">Delete</a>
                                </div>
                            </div>
                            <hr/>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    $(document).ready(
            function() {

                industry_load();
                
                $("#btn-add").click (
                    function () {
                        $("#box-edit").hide ();
                        $("#box-new").show ();
                        
                    });
                
                $("#btn-edit").click (
                    function () {
                        $("#box-edit").show ();
                        $("#box-new").hide ();
                        
                    });
            });

    function save(action, button) {
        
        var data = "";
        if (action == "edit") {
            data = $("#form-edit").serialize();
        } 
        
        if (action == "add") {
            data = $("#form-new").serialize();
        }
        
        if (action == "delete") {
            data = $("#form-edit").serialize();
        }
        
        jQuery.ajax({
            url: "<?php echo $base; ?>industry/" + action,
            data: data,
            type: "POST",
            beforeSend: function(xhr) {
                $(button).button('loading');
            }
        }).done(function(data) {
            $(button).button('reset');

            var result = $.parseJSON(data);
            //console.log(result);
            if (result.error == 1) {
                ////console.log(result.element);
                //$(result.element).next(".help-inline").html(result.message);
                //$(result.element).parent().parent().addClass('error');
                showAlert(result.message);
            } else {
                //$(result.element).parent().parent().removeClass('error');
                //$(result.element).next(".help-inline").html("");
                window.location.href="";
                //industry_load();
            }

        }).fail(function() {
        });
    }

    function industry_empty_table() {
        var r = confirm("This operation will empty all table data, are u sure?")
        if (r == true)
        {
            //alert("You pressed OK!")
        }
        else
        {
            return;
        }

        jQuery.ajax({
            url: "<?php echo $base; ?>industry/clean",
            data: {},
            type: "POST",
            beforeSend: function(xhr) {
                showAlert2("Empty table now......");
            }
        }).done(function(data) {

            var result = $.parseJSON(data);
            //console.log(result);
            if (result.error == 1) {
            } else {
                //hideAlert()
                window.location.href = "";
            }

        }).fail(function() {
            hideAlert();
        });
    }

    function industry_clear() {
        $("input[name='industry[parent_guid]']").val("");
        $("input[name='industry[parent]']").val("");
    }

    function industry_load() {
        jQuery.ajax({
            url: "<?php echo $base; ?>industry/industrylist",
            type: "GET",
            beforeSend: function(xhr) {
                showAlert2("Loading industry data now......");
            }
        }).done(function(data) {
            //alert (data);
            hideAlert();
            jQuery("#box-industry .body").html(data);

        }).fail(function() {
            hideAlert();
        });
    }

</script>
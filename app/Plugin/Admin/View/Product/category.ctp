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
            <div class="span7">
                <div class="slate">
                    <div class="page-header">
                        <h2>New Category</h2>
                    </div>
                    <form class="form-horizontal" id="form-new">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Name</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" name="category[name]" >
                                    <span class="help-inline"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Description</label>
                                <div class="controls">
                                    <textarea name="category[description]" style="width:280px" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Parent</label>
                                <div class="controls">
                                    <input type="text" class="input-medium" name="category[parent]" placeholder="Parent category">
                                    <input type="hidden" class="input-medium" name="category[parent_guid]">
                                    <span class="help-inline"></span>
                                    <a href="javascript:" class="btn btn-success" data-loading-text="Saving..." onclick="save();" id="btn-save">Save</a>
                                    <a href="javascript:" class="btn btn-success" onclick="category_clear();" id="btn-clear">Clear</a>
                                </div>
                            </div>
                            <hr/>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Selection</label>
                                <div class="controls">
                                    <input type="text" class="input-small" name="category[edit][name]" placeholder="name" data-guid="">
                                    <input type="text" class="input-mini" name="category[edit][order]" placeholder="order" data-guid="">
                                    <input type="hidden" class="input-mini" name="category[edit][guid]" placeholder="order" data-guid="">
                                    <span class="help-inline"></span>
                                    <a href="javascript:" class="btn btn-success" onclick="category_edit(true);">Update</a>
                                    <a href="javascript:" class="btn btn-info" onclick="category_edit(false);">Delete</a>
                                </div>
                            </div>
                            <hr/>
                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning"></label>
                                <div class="controls">
                                    <a href="javascript:" class="btn btn-info" onclick="category_empty_table();">Empty Category Table</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="span5">
                <div class="slate" id='box-category'>
                    <div class="page-header">
                        <h2>Category</h2>
                    </div>
                    <div class='body' style="height:500px;overflow: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
    $(document).ready(
            function() {

               category_load ();
            })

    function save() {
        jQuery.ajax({
            url: "<?php echo $base; ?>product/category/?action=add",
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
                category_load ();
            }

        }).fail(function() {
        });
    }
    
    function category_edit(update) {
    
        var url;
        var guid;
        var name;
        
        name = $("input[name='category[edit][name]']").val();
        if ($.trim (name) == "") {
            return;
        }
        
        if (update) {
            url = "<?php echo $base; ?>product/category/?action=update";
        } else {
            url = "<?php echo $base; ?>product/category/?action=delete";
            var r=confirm("This operation will delete this category and all its decendents, are u sure?")
            if (r==true)
            {
                //alert("You pressed OK!")
            }
            else
            {
                return;
            }
        }
        
        //or = $("input[name='category[edit][order]']").val();
        //name = $("input[name='category[edit][name]']").val();        
        
        jQuery.ajax({
            url: url,
            data: $("#form-new").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                showAlert ("Updating......");
            }
        }).done(function(data) {

            var result = $.parseJSON(data);
            if (result.error == 1) {
                if (update == false) {
                    window.location.href = "";
                }
            } else {
                hideAlert ();
                category_load ();
            }

        }).fail(function() {
            hideAlert ();
        });
    }
    
    function category_empty_table() {
        var r=confirm("This operation will empty all table data, are u sure?")
        if (r==true)
        {
            //alert("You pressed OK!")
        }
        else
        {
            return;
        }
        
        jQuery.ajax({
            url: "<?php echo $base; ?>product/category/?action=empty",
            data: {},
            type: "POST",
            beforeSend: function(xhr) {
                showAlert2("Empty table now......");
            }
        }).done(function(data) {

            var result = $.parseJSON(data);
            console.log(result);
            if (result.error == 1) {
            } else {
                //hideAlert()
                window.location.href = "";
            }

        }).fail(function() {
            hideAlert();
        });
    }
    
    function category_clear() {
        $("input[name='category[parent_guid]']").val("");
        $("input[name='category[parent]']").val("");
    }
    
    function category_load () {
        jQuery.ajax({
            url: "<?php echo $base; ?>product/category",
            type: "GET",
            beforeSend: function(xhr) {
                showAlert2("Loading category data now......");
            }
        }).done(function(data) {
            //alert (data);
            hideAlert();
            jQuery("#box-category .body").html(data);

        }).fail(function() {
            hideAlert();
        });
    }
 
</script>
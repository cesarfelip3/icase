<?php
$action_add = $base . "user_template/add";
$action_edit = $base . "user_template/edit";
$action_delete = $base . "user_template/delete";
$action_category_index = $base . "category";
$action_create = $base . "creator/create";
$action_pdf = $base . "user_template/pdf";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $this->webroot; ?>admin">Admin</a> <span class="divider">/</span>
            </li>
            <li class="active">Templates</li>
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
                <form class="form-inline" id='form-filter' method='GET'>
                    <div class="slate">
                        <input type='hidden' name='page' value='<?php echo $page; ?>' />
                        <input type="text" class="input-large" placeholder="Keyword..." name='keyword' value='<?php echo $keyword; ?>'>
                        <input type='text' class='input-small datepicker' name='start' placeholder='Start Date' readonly='readonly' value="<?php echo $start; ?>" />
                        <input type='text' class='input-small datepicker' name='end' placeholder='End Date' readonly='readonly' value="<?php echo $end; ?>" />
                        <select name='filter_category' id="filter_category" onchange="subcategorylist()" class="input-medium">
                            <option value=""> - Category - </option>
                            <?php foreach ($filter_categories as $key => $value) : ?>
                            <?php $value = $value['Category']; ?>
                                <option value="<?php echo $value['guid']; ?>" <?php if ($value['guid'] == $filter_category) echo 'selected="selected"'; ?>><?php echo $value['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name='filter_industry' class="input-medium">
                            <option value=""> - Industry - </option>
                            <?php foreach ($filter_industries as $key => $value) : ?>
                            <?php $value = $value['Industry']; ?>
                                <option value="<?php echo $value['guid']; ?>" <?php if ($value['guid'] == $filter_industry) echo 'selected="selected"'; ?>><?php echo $value['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="button" onclick='load(0);' class="btn btn-primary" name="action" value="Filter" />
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="span12 listing-buttons">
                <a href="<?php echo $action_category_index; ?>" class="btn btn-primary">Edit Category</a>
                <a href="<?php echo $action_add; ?>" class="btn btn-primary">New Template</a>
            </div>
            <div class="span12">
                <div class="slate">
                    <div class="page-header">
                        <div class="btn-group pull-right hide">
                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-download-alt"></i> Export
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="">CSV</a></li>
                                <li><a href="">Excel</a></li>
                                <li><a href="">PDF</a></li>
                            </ul>
                        </div>
                        <h2>Templates
                        <div style='display:inline' class='pull-right'>
                            <span class='label label-success'><?php echo $page + 1; ?> / <?php echo $pages; ?></span>                 </div></h2>
                    </div>
                    <table class="orders-table table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <?php foreach ($header as $key => $value) : ?>
                                <th><?php echo $value; ?></th>
                                <?php endforeach; ?>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty ($data)) : ?>
                            <?php $i = $page * $limit; ?>
                            <?php foreach ($data as $value) : ?>
                            <?php $value = $value['Template']; ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <?php foreach ($header as $key => $val) : ?>
                                <?php if ($key == 'thumbnails' && !empty ($value[$key])) : ?>
                                <td>
                                    <?php foreach ($value[$key] as $image) : ?>
                                    <img src='<?php echo $image; ?>' style="width:32px;border:1px solid #ccc;padding:5px;" />
                                    <?php endforeach;?>
                                </td>
                                <?php else : ?>
                                <td><?php echo $key == 'created' || $key == 'modified' ? date ("Y-m-d H:i:s", $value[$key]) : $value[$key]; ?></td>
                                <?php endif; ?>
                                <?php endforeach; ?>
                                <td class="actions" style="width:300px;">
                                    <a class="btn btn-small btn-danger" onclick="del('<?php echo $value['id']; ?>')">Remove</a>
                                    <a class="btn btn-small btn-primary" onclick="showPdf('<?php echo $value['guid']; ?>')">PDF</a>
                                    <a class="btn btn-small btn-primary" href="<?php echo $action_edit; ?>/?id=<?php echo $value['guid']; ?>" target="new">View Details</a>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="span12">
                <div class='pull-right'>
                    <?php echo $this->element("pagination", array ("plugin"=>"Admin", "page"=>$page, "form" => "#form-filter")); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element("action_del", array ("plugin"=>"Admin", "actionUrl" => $action_delete, "form" => "#form-filter", "message" => "Are you sure to remove this template?")); ?>

<script>
    $(document).ready (
        function () {
            categoryfilter ("", 0);
        });
        
    function load (page)
    {
        $("input[name=page]").val (page);
        $("#form-filter").submit ();
        
    }
    function categoryfilter (id, level)
    {
        jQuery.ajax({
            url: "<?php echo $base; ?>category/categoryfilter",
            type: "GET",
            beforeSend: function(xhr) {
                showAlert2 ("Loading categories......");
            }
        }).done(function(data) {
            //var html = $("#box-filter-category").html();
            if (data != "") {
                $("#box-filter-category").html (data);
            }
            hideAlert ();
        }).fail(function() {
            showAlert ("Failed");
        });
    }
    
    function subcategorylist ()
    {
        var guid = $("#filter_category").val();
        jQuery.ajax({
            url: "<?php echo $base; ?>template/subcategorylist/?id=" + guid,
            type: "GET",
            beforeSend: function(xhr) {
                showAlert2 ("Loading sub categories......");
            }
        }).done(function(data) {
            //var html = $("#box-filter-category").html();
            hideAlert ();
            
            if ($("#filter_subcategory")) {
                $("#filter_subcategory").remove ();
            }
            
            if (data == 'no') {
                return;
            }
            
            $("#filter_category").after(data);
        }).fail(function() {
            showAlert ("Failed");
        });
    }
    
    function categoryfilter_restore()
    {
        <?php if (!empty ($filter_categories)) : ?>
                
        <?php endif; ?>
    }
    
    function showPdf (guid)
    {
        jQuery.ajax({
            url: "<?php echo $action_pdf; ?>?id=" + guid,
            type: "GET",
            beforeSend: function(xhr) {
                showAlert2 ("Loading......");
            }
        }).done(function(data) {
            //var html = $("#box-filter-category").html();
            hideAlert ();
            
            if (data == "no") {
            		return;
            }
            
            $("#modal-preview .modal-body").html(data);
            $("#modal-preview").modal();
        }).fail(function() {
            showAlert ("Failed");
        });
    }
</script>

<!-- preview modal -->
<div id="modal-preview" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">PDF</h3>
    </div>
    <div class="modal-body" style="background:#ccc">
        <div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>
    </div>
    <div class="modal-footer">
    </div>
</div>
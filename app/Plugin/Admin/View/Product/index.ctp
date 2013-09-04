<?php
$action_add = $base . "product/add";
$action_edit = $base . "product/edit";
$action_delete = $base . "product/delete";
$action_category_index = $base . "category";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $this->webroot; ?>admin">Admin</a> <span class="divider">/</span>
            </li>
            <li class="active">Products</li>
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
                        <select name='filter'>
                            <option value=""> - Filter - </option>
                            <?php foreach ($filters as $key => $value) : ?>
                                <option value="<?php echo $key; ?>" <?php if ($key == $filter) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" class="btn btn-primary" name="action" value="Filter" />
                    </div>
                    <div class="slate" id="box-filter-category">
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="span12 listing-buttons">
                <a href="<?php echo $action_category_index; ?>" class="btn btn-primary">Edit Category</a>
                <a href="<?php echo $action_add; ?>" class="btn btn-primary">New Product</a>
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
                        <h2>Products</h2>
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
                            <?php $value = $value['Product']; ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <?php foreach ($header as $key => $val) : ?>
                                <?php if ($key == 'image') : ?>
                                <td><a class="thumbnail"><img src='<?php echo  $value['image']; ?>' style="width:32px" /></a></td>
                                <?php else : ?>
                                <td><?php echo $key == 'created' || $key == 'modified' ? date ("Y-m-d H:i:s", $value[$key]) : $value[$key]; ?></td>
                                <?php endif; ?>
                                <?php endforeach; ?>
                                <td class="actions">
                                    <a class="btn btn-small btn-danger" onclick="del('<?php echo $value['id']; ?>')">Remove</a>
                                    <a class="btn btn-small btn-primary" href="<?php echo $action_edit; ?>?id=<?php echo $value['guid']; ?>" target="new">View Details</a>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="span6">
                <?php echo $this->element("pagination", array ("plugin"=>"Admin", "page"=>$page, "form" => "#form-filter")); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element("action_del", array ("plugin"=>"Admin", "actionUrl" => $action_delete, "form" => "#form-filter", "message" => "Are you sure to remove this product?")); ?>

<script>
    $(document).ready (
        function () {
            categoryfilter ("", 0);
        });
        
    function categoryfilter (id, level)
    {
        jQuery.ajax({
            url: "<?php echo $base; ?>product/categoryfilter/?id=" + id + "&level=" + level,
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            //var html = $("#box-filter-category").html();
            if (data != "") {
                $("#box-filter-category").append (data);
            }
        }).fail(function() {
        });
    }
    
    
    
    function categoryfilter_restore()
    {
        <?php if (!empty ($filter_categories)) : ?>
                
        <?php endif; ?>
    }
</script>
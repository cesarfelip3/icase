<?php
$coupon_add = $base . "coupon" . DS . "add";
$coupon_edit = $base . "coupon" . DS . "edit";
$coupon_delete = $base . "coupon" . DS . "delete";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $this->webroot; ?>admin">Admin</a> <span class="divider">/</span>
            </li>
            <li class="active">Coupons</li>
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
                <div class="slate">
                    <form class="form-inline" id='form-filter' method='GET'>
                        <input type='hidden' name='page' value='<?php echo $page; ?>' />
                        <input type="text" class="input-large" placeholder="Keyword..." name='keyword' value='<?php echo $keyword; ?>'>
                        <input type='text' class='input-small datepicker' name='start' placeholder='Start Date' readonly='readonly' value="<?php echo $start; ?>" />
                        <input type='text' class='input-small datepicker' name='end' placeholder='End Date' readonly='readonly' value="<?php echo $end; ?>" />
                        <select name='filter'>
                            <option value=""> - Filter - </option>
                            <?php foreach ($filters as $key=>$value) :?>
                            <option value="<?php echo $key; ?>" <?php if ($key == $filter) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" class="btn btn-primary" name="action" value="Filter" />
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 listing-buttons">
                <a href="<?php echo $this->webroot; ?>admin/coupon/add" class="btn btn-primary">New Coupon</a>
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
                        <h2>Coupons</h2>
                    </div>
                    <table class="orders-table table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Discount</th>
                                <th>Quantity</th>
<!--                                <th>Tax</th>
                                <th>Discount</th>-->
                                <th>Created</th>
                                <th>Expired</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
                            $i = $page * $limit;
                            if (!empty ($data)) : 
                                foreach ($data as $value) : ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $value['Coupon']['name']; ?></td>
                                <td><?php echo $value['Coupon']['type']; ?></td>
                                <td>$<?php echo $value['Coupon']['value']; ?></td>
                                <td><?php echo $value['Coupon']['discount'] / 100; ?></td>
                               <td><?php echo $value['Coupon']['quantity']; ?></td>
                                <td><?php echo date ("Y-m-d H:i:s", $value['Coupon']['created']); ?></td>
                                <td><?php echo date ("Y-m-d H:i:s", $value['Coupon']['expired']); ?></td>
                                <td class="actions">
                                    <a class="btn btn-small btn-danger" onclick="del('<?php echo $value['Coupon']['id']; ?>')">Remove</a>
                                    <a class="btn btn-small btn-primary" href="<?php echo $coupon_edit; ?>?id=<?php echo $value['Coupon']['guid']; ?>" target="new">View Details</a>
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
            <div class="span6 listing-buttons pull-right">
<!--                <a href="<?php echo $this->webroot; ?>admin/category/" class="btn btn-primary">Edit Category</a>
                <a href="<?php echo $coupon_add; ?>" class="btn btn-primary">New Coupon</a>-->
            </div>
        </div>
    </div>
</div>
<?php echo $this->element("action_del", array ("plugin"=>"Admin", "actionUrl" => $base . "coupon/delete/", "form" => "#form-filter", "message" => "Are you sure to remove this coupon?")); ?>
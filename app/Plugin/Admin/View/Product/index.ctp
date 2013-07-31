<?php
$product_add = $base . "product" . DS . "add";
$product_edit = $base . "product" . DS . "edit";
$product_delete = $base . "product" . DS . "delete";
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
                <div class="slate">
                    <form class="form-inline">
                        <input type="text" class="input-large" placeholder="Keyword...">
                        <input type='text' class='input-large datepicker' placeholder='Start Date' />
                        <input type='text' class='input-large datepicker' placeholder='End Date' />
                        <select>
                            <option value=""> - Filter - </option>
                            <option value='template'>Case Template</option>
                            <option value='product'>Case Product</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 listing-buttons">
                <a href="<?php echo $this->webroot; ?>admin/product/category" class="btn btn-primary">Add New Category</a>
                <a href="<?php echo $this->webroot; ?>admin/product/add" class="btn btn-primary">Add New Item</a>
            </div>
            <div class="span12">
                <div class="slate">
                    <div class="page-header">
                        <div class="btn-group pull-right">
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
                                <th>Name</th>
                                <th>Type</th>
                                <th>Picture</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Tax</th>
                                <th>Created</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>iphone 5</td>
                                <td>template</td>
                                <td><img src='' /></td>
                                <td>iphone 5</td>
                                <td>54.32$</td>
                                <td>30</td>
                                <td>0.00$</td>
                                <td>2013-07-31</td>
                                <td class="actions">
                                    <a class="btn btn-small btn-danger" data-toggle="modal" href="#removeItem">Remove</a>
                                    <a class="btn btn-small btn-primary" href="<?php echo $product_edit; ?>" target="_blank">Edit</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal hide fade" id="removeItem">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Remove Item</h3>
                </div>
                <div class="modal-body">
                    <p>Are you sure you would like to remove this item?</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-danger">Remove</a>
                </div>
            </div>
            <div class="span6">
                <div class="pagination pull-left">
                    <ul>
                        <li><a href="#">Prev</a></li>
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>
                </div>
            </div>
            <div class="span6 listing-buttons pull-right">
                <a href="<?php echo $this->webroot; ?>admin/product/add" class="btn btn-primary">Add New Category</a>
                <a href="<?php echo $product_add; ?>" class="btn btn-primary">Add New Item</a>
            </div>
        </div>
    </div>
</div>
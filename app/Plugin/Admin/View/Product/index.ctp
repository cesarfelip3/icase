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
                    <form class="form-inline" id='form-filter' method='GET'>
                        <input type='hidden' name='page' value='<?php echo $page; ?>' />
                        <input type="text" class="input-large" placeholder="Keyword..." name='keyword'>
                        <input type='text' class='input-large datepicker' name='start' placeholder='Start Date' />
                        <input type='text' class='input-large datepicker' name='end' placeholder='End Date' />
                        <select name='filter'>
                            <option value=""> - Filter - </option>
                            <option value='type=template]'>Case Template</option>
                            <option value='type=product]'>Case Product</option>
                        </select>
                        <input type="submit" class="btn btn-primary" name="action" value="Filter" />
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 listing-buttons">
                <a href="<?php echo $this->webroot; ?>admin/product/category" class="btn btn-primary">Edit Category</a>
                <a href="<?php echo $this->webroot; ?>admin/product/add" class="btn btn-primary">New Product</a>
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
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Tax</th>
                                <th>Created</th>
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
                                <td><?php echo $value['Product']['name']; ?></td>
                                <td><?php echo $value['Product']['type']; ?></td>
                                <td><a class="thumbnail"><img src='<?php echo $this->webroot . "uploads/" . $value['Product']['image']; ?>' style="width:32px" /></a></td>
                                <td><?php echo $value['Product']['price']; ?>$</td>
                                <td><?php echo $value['Product']['quantity']; ?></td>
                                <td><?php echo $value['Product']['tax']; ?>$</td>
                                <td><?php echo date ("Y-m-d H:i:s", $value['Product']['created']); ?></td>
                                <td class="actions">
                                    <a class="btn btn-small btn-danger" onclick="del('<?php echo $value['Product']['id']; ?>')">Remove</a>
                                    <a class="btn btn-small btn-primary" href="<?php echo $product_edit; ?>?id=<?php echo $value['Product']['guid']; ?>" target="_blank">Edit</a>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<!--            <div class="modal hide fade" id="removeItem">
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
            </div>-->
            <div class="span6">
                <div class="pagination pull-left">
                    <ul>
                        <li><a href="javascript:" data-page="<?php echo $page - 1; ?>">Prev</a></li>
                        <?php
                        
                        $j = 0;
                        for (; $j < $pages; ++$j) : ?>
                        <li <?php if ($j == $page) : echo 'class="active"'; endif; ?>>
                            <a href="javascript:" data-page="<?php echo $j; ?>"><?php echo $j + 1; ?></a>
                        </li>
                        <?php
                        endfor; ?>
                        <li><a href="javascript:" data-page="<?php echo $page + 1; ?>">Next</a></li>
                    </ul>
                </div>
            </div>
            <div class="span6 listing-buttons pull-right">
                <a href="<?php echo $this->webroot; ?>admin/product/category" class="btn btn-primary">Edit Category</a>
                <a href="<?php echo $product_add; ?>" class="btn btn-primary">New Product</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready 
    (
        function () 
        {
            $(".pagination a").click (
                function () {
                    var page = $(this).data('page');
                    $('input[name=page]').val (page);
                    $("#form-filter").submit();
                    
                });
        }
    );
    
    function del (id) {
        var r=confirm("This operation will delete this category and all its decendents, are u sure?")
        if (r==true)
        {
            //alert("You pressed OK!")
        }
        else
        {
            return;
        }
        jQuery.ajax({
            url: "<?php echo $base; ?>product/delete/?id=" + id,
            type: "GET",
            beforeSend: function(xhr) {
            }
        }).done(function(data) {
            $("#form-filter").submit ();
        }).fail(function() {
        });
    }
        
        
        
</script>
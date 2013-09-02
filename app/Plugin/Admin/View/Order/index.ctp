<div class="secondary-masthead">

    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $base; ?>">Admin</a> <span class="divider">/</span>
            </li>
            <li class="active">Orders</li>
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
                            <?php foreach ($filters as $key => $value) : ?>
                                <option value="<?php echo $key; ?>" <?php if ($key == $filter) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" class="btn btn-primary" name="action" value="Filter" />
                    </form>
                </div>
            </div>
        </div>
        <form id="form-edit" method="POST">
            <div class="row">
                <div class="span12 listing-buttons">
<!--                    <a class="btn btn-primary" href="javascript:">Settings</a>-->
<!--                    <a class="btn btn-primary" onclick="save('edit/?id=0')" href="javascript:">Update Selected</a>-->
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
                            <h2>Orders</h2>
                        </div>
                        <table class="orders-table table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Orders</th>
                                    <th>Shopping Cart ID</th>
                                    <th class="value">Quantity</th>
                                    <th class="value">Amount</th>
                                    <th class="value">Status</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                <?php if (!empty($data)) : ?>
                                    <?php foreach ($data as $value) : ?>
                                        <tr>
                                            <td><input type="checkbox" name="order[selected][]" value="<?php echo $value['Order']['id']; ?>" /></td>
                                            <td><a href="<?php echo $base; ?>order/view/?id=<?php echo $value['Order']['guid']; ?>" style="font-size:14px;">#<?php echo $value['Order']['guid']; ?> - <?php echo $value['Order']['title']; ?></a> <span class="label label-info"><?php echo $value['Order']['status']; ?></span><br /><span class="meta" style="color:black;font-size:14px;"><?php echo date("F j, Y, g:i a", $value['Order']['created']); ?></span></td>
                                            <td>
                                                <?php echo "#" . $value['Order']['group_guid']; ?>
                                            </td>
                                            <td class="value">
                                                <?php echo $value['Order']['quantity']; ?>
                                            </td>
                                            <td class="value">
                                                $<?php echo $value['Order']['amount']; ?>
                                            </td>
                                            <td class="value" style="text-transform: capitalize;">
                                                <?php echo $value['Order']['status']; ?>
                                            </td>
                                            <td class="actions">
<!--                                                <a class="btn btn-small btn-primary" onclick="save('edit/?id=<?php echo $value['Order']['id']; ?>')" href="javascript:">Update</a>-->
                                                <a class="btn btn-small btn-primary" href="<?php echo $base; ?>order/view/?id=<?php echo $value['Order']['guid']; ?>">View Order</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="span6">
                    <?php echo $this->element("pagination", array("plugin" => "Admin", "page" => $page, "form" => "#form-filter")); ?>
                </div>
                <div class="span6 listing-buttons pull-right">
<!--                    <a class="btn btn-primary" onclick="save('edit/?id=0')" href="javascript:">Update Selected</a>-->
                </div>
            </div>
        </form>
    </div>
</div>
<script>
function save(action, button) {
        
        var data = "";
        if (action.substring (0, 4) == "edit") {
            data = $("#form-edit").serialize();
        } 
        
        if (action == "add") {
            data = $("#form-new").serialize();
        }
        
        if (action == "delete") {
            data = $("#form-edit").serialize();
        }
        
        jQuery.ajax({
            url: "<?php echo $base; ?>order/" + action,
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
            }

        }).fail(function() {
        });
    }    
</script>
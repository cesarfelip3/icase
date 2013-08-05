
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $base; ?>">Admin</a> <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo $base; ?>Order/">Orders</a> <span class="divider">/</span>
            </li>
            <li class="active">View Order</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <div class="alert alert-info hide">
            <a class="close" data-dismiss="alert" href="#">x</a>
            <h4 class="alert-heading">Information</h4>
            The view order template would be used to display order information.
        </div>
        <div class="row">
            <div class="span12 listing-buttons">
                <button class="btn btn-primary">View/Print Invoice</button>
            </div>
        </div>
        <div class="row">
            <div class="span4">
                <div class="slate">
                    <div class="page-header">
                        <h2>Order Details</h2>
                    </div>
                    <p><strong>Order #:</strong> <?php echo $data['Order']['id']; ?></p>
                    <p><strong>Order Date:</strong> <?php echo date("F j, Y, g:i a", $data['Order']['created']); ?></p>
                    <p><strong>Payment Method:</strong> PayPal</p>
                    <p><strong>Transaction ID:</strong> <?php echo $data['Order']['guid']; ?></p>
                    <p><strong>Voucher Code:</strong> 12345 (10% Discount)</p>
                    <p><strong>Member:</strong> <a href="">Joe Bloggs</a></p>
                </div>
            </div>
            <div class="span4">
                <div class="slate">
                    <div class="page-header">
                        <h2>Billing Address</h2>
                    </div>
                    <p><?php echo $deliver['firstname'] . " " . $deliver['lastname']; ?></p>
                    <p><?php echo $deliver['address']; ?></p>
                    <p><?php echo $deliver['city']; ?></p>
                    <p><?php echo $deliver['country']; ?></p>
                    <p><?php echo $deliver['zipcode']; ?></p>
                </div>
            </div>
            <div class="span4">
                <div class="slate">
                    <div class="page-header">
                        <h2>Delivery Address</h2>
                    </div>
                    <p><?php echo $deliver['firstname'] . " " . $deliver['lastname']; ?></p>
                    <p><?php echo $deliver['address']; ?></p>
                    <p><?php echo $deliver['city']; ?></p>
                    <p><?php echo $deliver['country']; ?></p>
                    <p><?php echo $deliver['zipcode']; ?></p>
                </div>
            </div>
        </div>
        <form id="form-edit">
        <div class="row">
            <div class="span12">
                <div class="slate">
                    <div class="page-header">
                        <h2>Ordered Items</h2>
                    </div>
                    <table class="orders-table table">
                        <thead>
                            <tr>
                                <th>Orders</th>
                                <th class="value">Value</th>
                                <th class="actions">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href=""><?php echo $data['Order']['title']; ?></a> <span class="label label-info"><?php echo $data['Order']['status']; ?></span></td>
                                <td class="value">
                                    $<?php echo $data['Order']['amount']; ?>
                                </td>
                                <td class="actions">
                                    <select class="input-medium" name="order[<?php echo $data['Order']['id']; ?>][status]" onchange="save('edit/?id=<?php echo $data['Order']['id']; ?>')">
                                        <?php foreach ($status as $key => $state) : ?>
                                            <option value="<?php echo $key; ?>" <?php if ($data['Order']['status'] == $key) echo 'selected="selected"'; ?>><?php echo $state; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </form>
        <div class="row">
            <div class="span12">
                <?php if (!empty($data['Order']['file'])) : ?>
                    <a class="thumbnail"><img src="<?php echo $this->webroot . "uploads/" . $data['Order']['file']; ?>" /></a>
                    <?php endif; ?>
            </div>
        </div>
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
            console.log(result);
            if (result.error == 1) {
                //console.log(result.element);
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
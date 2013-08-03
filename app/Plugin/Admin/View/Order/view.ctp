
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="#">Admin</a> <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Store</a> <span class="divider">/</span>
            </li>
            <li>
                <a href="#">Orders</a> <span class="divider">/</span>
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
                                    <select class="input-small">
                                        <option value="paid">Paid</option>
                                        <option value="dispatched">Dispatch</option>
                                        <option value="cancel">Cancel</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <?php if (!empty ($data['Order']['file'])) : ?>
                <a class="thumbnail"><img src="<?php echo $this->webroot . "uploads/" . $data['Order']['file']; ?>" /></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

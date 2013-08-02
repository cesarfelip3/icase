
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
                    <p><strong>Order Date:</strong> <?php echo date ("F j, Y, g:i a", $data['Order']['created']); ?></p>
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
                                <th class="actions">Dispatch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="">Product Name</a> <span class="label label-info">6 In Stock</span><br /><span class="meta">Item summary or notes</span></td>
                                <td class="value">
                                    $132.00
                                </td>
                                <td class="actions">
                                    <input type="checkbox" />
                                </td>
                            </tr>
                            <tr>
                                <td><a href="">Product Name</a> <span class="label label-info">6 In Stock</span><br /><span class="meta">Item summary or notes</span></td>
                                <td class="value">
                                    $132.00
                                </td>
                                <td class="actions">
                                    <input type="checkbox" />
                                </td>
                            </tr>
                            <tr>
                                <td><a href="">Product Name</a> <span class="label label-info">6 In Stock</span><br /><span class="meta">Item summary or notes</span></td>
                                <td class="value">
                                    $132.00
                                </td>
                                <td class="actions">
                                    <input type="checkbox" />
                                </td>
                            </tr>
                            <tr>
                                <td><a href="">Product Name</a> <span class="label label-success">Dispatched</span><br /><span class="meta">Item summary or notes</span></td>
                                <td class="value">
                                    $132.00
                                </td>
                                <td class="actions">
                                    Consignment # 1234
                                </td>
                            </tr>
                            <tr>
                                <td><a href="">Product Name</a> <span class="label label-important">Out Of Stock</span><br /><span class="meta">Item summary or notes</span></td>
                                <td class="value">
                                    $132.00
                                </td>
                                <td class="actions">
                                    <input type="checkbox" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="span12 listing-buttons">
                <button class="btn btn-primary">Dispatch Selected</button>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <div class="slate">
                    <div class="page-header">
                        <h2>Order History</h2>
                    </div>
                    <table class="orders-table table">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th class="actions">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1 Item Dispatched - Consignment # 1234</td>
                                <td class="date">
                                    Today at 14:55
                                </td>
                            </tr>
                            <tr>
                                <td>Order Paid via Paypal</td>
                                <td class="date">
                                    Today at 13:42
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 footer">
                <p>&copy; Website Name 2012</p>
            </div>
        </div>
    </div>
</div>


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
                    <p><strong>Order #:</strong> <?php echo $data['Order']['guid']; ?></p>
                    <p><strong>Order Date:</strong> <?php echo date("F j, Y, g:i a", $data['Order']['created']); ?></p>
                    <p><strong>Payment Method:</strong> <?php echo $data['Order']['payment_gateway']; ?></p>
                    <p><strong>Transaction ID:</strong> <?php echo $data['Order']['transaction_id']; ?></p>
                </div>
            </div>
            <div class="span4">
                <div class="slate">
                    <div class="page-header">
                        <h2>Billing Address</h2>
                    </div>
                    <address>
                        <strong><?php echo $bill['name']; ?></strong><br>
                        <p><?php echo $bill['address']; ?></p>
                        <abbr title="Zip Code">Zip code:</abbr> <?php echo $deliver['zipcode']; ?><br/>
                        <abbr title="Phone">P:</abbr> <?php echo $bill['phone']; ?><br/>
                        <abbr title="City">City:</abbr> <?php echo $bill['city']; ?><br/>
                        <abbr title="State">State:</abbr> <?php echo $bill['state']; ?><br/>
                        <abbr title="Country">Country:</abbr> <?php echo $bill['country']; ?><br/>
                    </address>
                </div>
            </div>
            <div class="span4">
                <div class="slate">
                    <div class="page-header">
                        <h2>Delivery Address</h2>
                    </div>
                    <address>
                        <strong><?php echo $deliver['firstname'] . " " . $deliver['lastname']; ?>(<?php echo $deliver['email']; ?>)</strong><br>
                        <p><?php echo $deliver['address']; ?></p>
                        <abbr title="Zip Code">Zip code:</abbr> <?php echo $deliver['zipcode']; ?><br/>
                        <abbr title="Phone">P:</abbr> <?php echo $deliver['phone']; ?><br/>
                        <abbr title="City">City:</abbr> <?php echo $deliver['city']; ?><br/>
                        <abbr title="State">State:</abbr> <?php echo $deliver['state']; ?><br/>
                        <abbr title="Country">Country:</abbr> <?php echo $deliver['country']; ?><br/>
                    </address>
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
                                    <th class="value">Status</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href=""><?php echo $data['Order']['title']; ?></a> <span class="label label-info"><?php echo $data['Order']['status']; ?></span></td>
                                    <td class="value">
                                        $<?php echo $data['Order']['amount']; ?>
                                    </td>
                                    <td>
                                        <select class="input-medium" name="order[<?php echo $data['Order']['id']; ?>][status]" onchange="save('edit/?id=<?php echo $data['Order']['id']; ?>')">
                                            <?php foreach ($status as $key => $state) : ?>
                                                <option value="<?php echo $key; ?>" <?php if ($data['Order']['status'] == $key) echo 'selected="selected"'; ?>><?php echo $state; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="actions">
                                        <a href="javascript:" onclick="$('#myModal').modal();" class="btn btn-primary btn-small">Send Email</a>
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
                <?php if (!empty($data['Order']['attachement'])) : ?>
                    <a class="thumbnail"><img src="<?php echo $this->webroot . "uploads/preview/" . $data['Order']['attachement']; ?>" /></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Email Notification</h3>
    </div>
    <div class="modal-body">
        <form>
            <fieldset>
                <div class="input-prepend">
                    <span class="add-on" style="width:80px;">Email</span>
                    <input class="input-medium" id="prependedInput" type="text" value="<?php echo $data['Order']['email']; ?>" placeholder="User email">
                </div>
                <div class="input-prepend">
                    <span class="add-on" style="width:80px;">Subject</span>
                    <input class="input-xlarge" id="prependedInput" type="text" placeholder="Username" value="The Status of Your Order Has Changed">
                </div>
                <div>
                    <textarea class="ckeditor" cols="80" id="editor1" name="" rows="10"></textarea>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary">Send</button>
    </div>
</div>
<script>
                                            function save(action, button) {

                                                var data = "";
                                                if (action.substring(0, 4) == "edit") {
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
                                                        window.location.href = "";
                                                    }

                                                }).fail(function() {
                                                });
                                            }
</script>

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
                    <p><strong>Order #:</strong> <?php echo $data['guid']; ?></p>
                    <p><strong>Order Date:</strong> <?php echo date("F j, Y, g:i a", $data['created']); ?></p>
                    <p><strong>Payment Method:</strong> <?php echo $data['payment_gateway']; ?></p>
                    <p><strong>Transaction ID:</strong> <?php echo $data['transaction_id']; ?></p>
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
                <div class="span7">
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href=""><?php echo $data['title']; ?></a> <span class="label label-info"><?php echo $data['status']; ?></span></td>
                                    <td class="value">
                                        $<?php echo $data['amount']; ?>
                                    </td>
                                    <td>
                                        <select class="input-medium" name="order[<?php echo $data['id']; ?>][status]" onchange="save('edit/?id=<?php echo $data['id']; ?>')">
                                            <?php foreach ($status as $key => $state) : ?>
                                                <option value="<?php echo $key; ?>" <?php if ($data['status'] == $key) echo 'selected="selected"'; ?>><?php echo $state; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>

                                        <a class="btn btn-primary" onclick="send_email();" data-loading-text="Saving..." id="btn-sendemail">Send Email Now</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="span5">
                    <div class="input-prepend">
                        <span class="add-on" style="width:80px;">Email</span>
                        <input class="input-medium" id="prependedInput" type="text" value="<?php echo $data['notification_email']; ?>" name="email[email]">
                    </div>
                    <div class="input-prepend">
                        <span class="add-on" style="width:80px;">Subject</span>
                        <input class="input-xlarge" id="prependedInput" type="text" value="The status of your order has changed" name="email[subject]">
                    </div>
                    <div>
                        <textarea class="ckeditor" cols="80" id="editor1" name="email[content]" rows="10">
<div>Thank you for your order from BeaUTAHful Creations<b>! </b>We wanted to let you know that your order was shipped via USPS, USPS Priority Mail on 7/27/2013.  You can track your package at any time using the link below.</div>
<div>
<b>Track Your Shipment:</b> <a href="https://tools.usps.com/go/TrackConfirmAction.action?tLabels=9405510200986104431161">9405510200986104431161</a><br></div>
                        </textarea>
                    </div>
                    <div class="well">
                        Edit email content to meet your requirement.
                    </div>
                </div>
            </div>
        </form>
        <?php if ($data['type'] == 'template') : ?>
        <div class="row">
            <div class="span12">
                <?php if (!empty($data['attachement'])) : ?>
                    <a class="thumbnail"><img src="<?php echo $this->webroot . "uploads/preview/" . str_replace (".", "_admin.", $data['attachement']); ?>" /></a>
                <?php endif; ?>
            </div>
            <div class="span12">
                <?php if (!empty($data['attachement'])) : ?>
                    <a class="thumbnail"><img src="<?php echo $this->webroot . "uploads/preview/" . str_replace (".", "_user.", $data['attachement']); ?>" /></a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<div id="myModal" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Email Notification</h3>
    </div>
    <div class="modal-body">
        <form>
            <fieldset>
                
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
    
    function send_email ()
    {
        jQuery.ajax({
            url: "<?php echo $base; ?>order/sendemail/?id=<?php echo $data['guid']; ?>",
            data: data = $("#form-edit").serialize(),
            type: "POST",
            beforeSend: function(xhr) {
                $("#btn-sendemail").button('loading');
                showAlert2 ("Sending email......");
            }
        }).done(function(data) {
            $("#btn-snedemail").button('reset');

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
            
            hideAlert ();

        }).fail(function() {
            $("#btn-snedemail").button('reset');
        });
     }
</script>
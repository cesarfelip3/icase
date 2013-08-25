<style tyle="text/css">
    a.title {text-decoration: none;color:orange}
</style>
<div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Type</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Quantity</th>
                <th>Modified</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty ($data)) : $i = 0;?>
            <?php foreach ($data as $value) : ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $value['Order']['title']; ?></td>
                <td><?php if ($value['Order']['type'] == 'template') echo "custom"; else echo "product"; ?></td>
                <td><?php echo $value['Order']['status']; ?></td>
                <td><?php echo $value['Order']['amount']; ?></td>
                <td><?php echo $value['Order']['quantity']; ?></td>
                <td><?php echo date ("m/d/y g:i:s A", $value['Order']['modified']); ?></td>
                <td><a href="javascript:" class="btn btn-info btn-small" onclick="order_view('<?php echo $value['Order']['guid']; ?>')">View</a></td>
            </tr>
            <?php endforeach; ?>
            <?php else :  ?>
            <tr>
                <td colspan="4"><em class="text-warning">No orders yet</em></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
    function order_view (id)
    {
        $("#modal-view").modal();
        
        jQuery.ajax({
            url: "<?php echo $this->webroot; ?>order/view/?id=" + id,
            type: "GET",
            beforeSend: function(xhr) {
                $(".ajax-loading-indicator").show();
            }
        }).done(function(data) {
            $(".ajax-loading-indicator").hide ();
            $("#modal-view .modal-body").html (data);
        }).fail(function() {
        });
    }
</script> 

<!-- modal -->
<div id="modal-view" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Order Details</h3>
    </div>
    <div class="modal-body" style=''>
        <div class="ajax-loading-indicator hide" style=""><a href="javascript:" style="font-size:14px;"><i class="icon-refresh icon-spin"></i> Loading ....</a></div>
    </div>
    <div class="modal-footer">
    </div>
</div>
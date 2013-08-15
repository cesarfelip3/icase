
<div class="main-area dashboard">
    <div class="container">
        <div class="row">
            <div class="span12">
                <div class="slate clearfix">
                    <a class="stat-column" href="#">
                        <span class="number" id="label-orders">0</span>
                        <span>Open Orders</span>
                    </a>
                    <a class="stat-column" href="#">
                        <span class="number" id="label-members">0</span>
                        <span>Members</span>
                    </a>
                    <a class="stat-column" href="#">
                        <span class="number" id="label-revenue">$0</span>
                        <span>Revenue</span>
                    </a>
                    <a class="stat-column" href="#">
                        <span class="number" id="label-subscribes">0</span>
                        <span>Subscribers</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span6">
                <div class="slate">
                    <div class="page-header">
                        <h2><i class="icon-shopping-cart pull-right"></i>Latest Orders</h2>
                    </div>
                    <div id="box-orders">
                        
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="slate">
                    <div class="page-header">
                        <h2><i class="icon-tasks pull-right"></i>Stock Status</h2>
                    </div>
                    <div id="box-stock">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span6">
                <div class="slate">
                    <div class="page-header">
                        <h2><i class="icon-envelope pull-right"></i>Latest Subscribe</h2>
                    </div>
                    <div>
                        
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="slate">
                    <div class="page-header">
                        <h2><i class="icon-user pull-right"></i>Latest Registeration</h2>
                    </div>
                    <div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready (
        function () {
            init_orders ();
    });
    
    function init_orders ()
    {
        jQuery.ajax({
            url: "<?php echo $base; ?>/?action=orders",
            type: "GET",
            beforeSend: function(xhr) {
                showAlert2 ("Loading...");
            }
        }).done(function(data) {

            $("#box-orders").html (data);
            $("#label-orders").text($("#data-statistics").data('orders'));
            $("#label-members").text($("#data-statistics").data('members'));
            $("#label-revenue").text("$" + $("#data-statistics").data('revenue'));
            $("#label-subscribes").text($("#data-statistics").data('subscribes'));
            
            init_stock ();
            
            hideAlert ();

        }).fail(function() {
            hideAlert();
        });
    }
    
    function init_stock ()
    {
        jQuery.ajax({
            url: "<?php echo $base; ?>/?action=stock",
            type: "GET",
            beforeSend: function(xhr) {
                showAlert2 ("Loading...");
            }
        }).done(function(data) {

            $("#box-stock").html (data);
            hideAlert ();

        }).fail(function() {
            hideAlert();
        });
    }
    
    
</script>

<style tyle="text/css">
    a.title {text-decoration: none;color:orange}
</style>
<div class='row-fluid'>
    <div class='span3'>
        <div class="well" id="box-category" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding-top:5px">
            <h3 style="border-bottom:1px solid #ccc">My Dashboard</h3>
            <ul class="nav nav-list">
                <li class="active"><a href="<?php echo $this->webroot; ?>user/">Dashboard</a></li>
                <li><a href="<?php echo $this->webroot; ?>order/">Orders</a></li>
                <li><a href="<?php echo $this->webroot; ?>creation/">Creations</a></li>
                <li><a href="<?php echo $this->webroot; ?>user/profile">Profile</a></li>
            </ul>
        </div>
    </div>
    <div class='span8'>
        <div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
            <div class="span4">
                <h1><a class="title" href="javascript:"><i class="icon-shopping-cart icon-2x"></i> 3 Orders</a></h1>
            </div>
            <div class="span4">
                <h1><a class="title" href="javascript:"><i class="icon-picture icon-2x"></i> 3 Creations</a></h1>
            </div>
            <div class="span4">
                <h1><a class="title" href="javascript:"><i class="icon-user icon-2x"></i> Your Profile</a></h1>
            </div>
        </div>
        <div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
            <?php if ($_identity['active'] == 0) : ?>
            <div class='alert' style='font-size:14px;'>
                <div>Your account email address isn't verifed yet, you can resend  <a href=''>active link</a> now to active your account</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
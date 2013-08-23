<style tyle="text/css">
    a.title {text-decoration: none;color:orange}
</style>
<div class='row-fluid'>
    <div class='span3'>
        <div class="well" id="box-category" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding-top:5px">
            <h3 style="border-bottom:1px solid #ccc">My Dashboard</h3>
            <ul class="nav nav-list">
                <li><a href="<?php echo $this->webroot; ?>user/">Dashboard</a></li>
                <li class="active"><a href="<?php echo $this->webroot; ?>user/order">Orders</a></li>
                <li><a href="<?php echo $this->webroot; ?>user/creation">Creations</a></li>
                <li><a href="<?php echo $this->webroot; ?>user/profile">Profile</a></li>
            </ul>
        </div>
    </div>
    <div class='span8'>
        <div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>title</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
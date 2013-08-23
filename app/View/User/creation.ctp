<style tyle="text/css">
    a.title {text-decoration: none;color:orange}
</style>
<div class='row-fluid'>
    <div class='span3'>
        <div class="well" id="box-category" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding-top:5px">
            <h3 style="border-bottom:1px solid #ccc">My Dashboard</h3>
            <ul class="nav nav-list">
                <li><a href="<?php echo $this->webroot; ?>user/">Dashboard</a></li>
                <li><a href="<?php echo $this->webroot; ?>user/order">Orders</a></li>
                <li class="active"><a href="<?php echo $this->webroot; ?>user/creation">Creations</a></li>
                <li><a href="<?php echo $this->webroot; ?>user/profile">Profile</a></li>
            </ul>
        </div>
    </div>
    <div class='span8'>
        <div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
            <h2>In Progress</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Sample</th>
                        <th>Created</th>
                        <th class="pull-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td></td>
                        <td><img src="" /></td>
                        <td>2013-08-07 23:03:05</td>
                        <td class="pull-right">
                            <a href="javascript:" class="btn btn-info btn-small">Load</a>&nbsp;&nbsp;
                            <a href="javascript:" class="btn btn-info btn-small">Download</a>&nbsp;&nbsp;
                            <a class="btn btn-info btn-small">Delete</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
            <h2>Final Creations</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Sample</th>
                        <th>Created</th>
                        <th class="pull-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td></td>
                        <td><img src="" /></td>
                        <td>2013-08-07 23:03:05</td>
                        <td class="pull-right"><a href="javascript:" class="btn btn-info btn-small">Download</a>&nbsp;&nbsp;<a class="btn btn-info btn-small">Delete</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
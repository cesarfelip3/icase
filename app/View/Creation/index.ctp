<style tyle="text/css">
    a.title {text-decoration: none;color:orange}
</style>
<div class='row-fluid'>
    <div class='span3'>
        <div class="well" id="box-category" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding-top:5px">
            <h3 style="border-bottom:1px solid #ccc">My Dashboard</h3>
            <ul class="nav nav-list">
                <li><a href="<?php echo $this->webroot; ?>user/">Dashboard</a></li>
                <li class="active"><a href="<?php echo $this->webroot; ?>creation/">Creations</a></li>
                <li><a href="<?php echo $this->webroot; ?>order/">Orders</a></li>
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
                        <th>Modified</th>
                        <th class="pull-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)) : $i = 0; ?>
                        <?php foreach ($data as $value) : ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $value['Creation']['name']; ?></td>
                                <td><?php echo date ("m/d/y g:i:s A", $value['Creation']['modified']); ?></td>
                                <td class="pull-right">
                                    <a href="<?php echo $this->webroot; ?>create/?id=<?php echo $value['Creation']['guid']; ?>" class="btn btn-info btn-small">Load</a>
                                    <a class="btn btn-info btn-small" href='<?php echo $this->webroot; ?>creation/delete/?id=<?php echo $value['Creation']['guid']; ?>'>Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                            <tr>
                                <td colspan="4"><em class="text-warning">No data yet.</em></td>
                            </tr>  
                            
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (false) : ?>
        <div class="row-fluid" style="margin-top:20px;background-color:white;border:1px solid #ccc;padding:15px;border-radius: 5px;">
            <h2>Final Creations</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sample</th>
                        <th>Created</th>
                        <th class="pull-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data2)) : $i = 0; ?>
                        <?php foreach ($data2 as $value) : ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><img src="<?php echo $this->webroot . "uploads/user/" . $value['Order']['file']; ?>" style="width:300px;border:1px solid #ccc;" /></td>
                                <td><?php echo date ("m/d/y g:i:s A", $value['Order']['modified']); ?></td>
                                <td class="pull-right">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                            <tr>
                                <td colspan="4"><em class="text-warning">No data yet.</em></td>
                            </tr>  
                            
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
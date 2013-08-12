<?php
$mail_add = $base . "mail" . DS . "add";
$mail_edit = $base . "mail" . DS . "edit";
$mail_delete = $base . "mail" . DS . "delete";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $this->webroot; ?>admin">Admin</a> <span class="divider">/</span>
            </li>
            <li class="active">Email Templates</li>
        </ul>
    </div>
</div>
<div class="main-area dashboard">
    <div class="container">
        <div class="alert alert-info hide">
            <a class="close" data-dismiss="alert" href="#">x</a>
            <h4 class="alert-heading">Information</h4>
        </div>
        <div class="row">
            <div class="span12">
                <div class="slate">
                    <form class="form-inline" id='form-filter' method='GET'>
                        <input type='hidden' name='page' value='<?php echo $page; ?>' />
                        <input type="text" class="input-large" placeholder="Keyword..." name='keyword' value='<?php echo $keyword; ?>'>
                        <input type='text' class='input-small datepicker' name='start' placeholder='Start Date' readonly='readonly' value="<?php echo $start; ?>" />
                        <input type='text' class='input-small datepicker' name='end' placeholder='End Date' readonly='readonly' value="<?php echo $end; ?>" />
                        <select name='filter' class="hide">
                            <option value=""> - Filter - </option>
                        </select>
                        <input type="submit" class="btn btn-primary" name="action" value="Filter" />
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 listing-buttons">
                <a href="<?php echo $this->webroot; ?>admin/mail/add" class="btn btn-primary">New Template</a>
            </div>
            <div class="span12">
                <div class="slate">
                    <div class="page-header">
                        <h2>Mail Templates</h2>
                    </div>
                    <table class="orders-table table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Usage</th>
                                <th>Created</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = $page * $limit;
                            if (!empty ($data)) : 
                                foreach ($data as $value) : ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $value['Product']['name']; ?></td>
                                <td><?php echo $value['Product']['type']; ?></td>
                                <td><?php echo $value['Product']['discount']; ?>%</td>
                                <td><?php echo date ("Y-m-d H:i:s", $value['Product']['created']); ?></td>
                                <td class="actions">
                                    <a class="btn btn-small btn-danger" onclick="del('<?php echo $value['Product']['id']; ?>')">Remove</a>
                                    <a class="btn btn-small btn-primary" href="<?php echo $mail_edit; ?>?id=<?php echo $value['Product']['guid']; ?>" target="_blank">View Details</a>
                                </td>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="span6">
                <?php echo $this->element("pagination", array ("plugin"=>"Admin", "page"=>$page, "form" => "#form-filter")); ?>
            </div>
            <div class="span6 listing-buttons pull-right">
                <a href="<?php echo $mail_add; ?>" class="btn btn-primary">New Template</a>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element("action_del", array ("plugin"=>"Admin", "actionUrl" => $base . "mail/delete/", "form" => "#form-filter", "message" => "Are you sure to remove this mail?")); ?>
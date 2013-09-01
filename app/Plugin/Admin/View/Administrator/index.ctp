<?php
$action_add = $base . "administrator" . DS . "add";
$action_edit = $base . "administrator" . DS . "edit";
$action_delete = $base . "administrator" . DS . "delete";
?>
<div class="secondary-masthead">
    <div class="container">
        <ul class="breadcrumb">
            <li>
                <a href="<?php echo $this->webroot; ?>admin">Admin</a> <span class="divider">/</span>
            </li>
            <li class="active">Administrators</li>
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
                        <select name='filter'>
                            <option value=""> - Filter - </option>
                            <?php foreach ($filters as $key=>$value) :?>
                            <option value="<?php echo $key; ?>" <?php if ($key == $filter) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" class="btn btn-primary" name="action" value="Filter" />
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12 listing-buttons">
                <a href="<?php echo $action_add; ?>" class="btn btn-primary">New Administrator</a>
            </div>
            <div class="span12">
                <div class="slate">
                    <div class="page-header hide">
                        <div class="btn-group pull-right">
                            <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-download-alt"></i> Export
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="">CSV</a></li>
                                <li><a href="">Excel</a></li>
                                <li><a href="">PDF</a></li>
                            </ul>
                        </div>
                        <h2>Administrators</h2>
                    </div>
                    <table class="orders-table table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Country/State/City/Address</th>
                                <th>Created / Modified</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty ($data)) : ?>
                            <?php $i = $page * $limit; ?>
                            <?PHP foreach ($data as $value) : ?>
                            <?php $value = $value['Product']; ?>
                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $value['name']; ?></td>
                                <td><?php echo $value['email']; ?></td>
                                <td><?php echo $value['type']; ?></td>
                                <td><?php echo $value['firstname'] . " " . $value['lastname']; ?></td>
                                <td><?php echo $value['phone']; ?></td>
                                <td><?php echo $value['country'] . DS . $value['state'] . DS . $value['city'] . DS . $value['address']; ?></td>
                                <td><?php echo date ("Y-m-d H:i:s ", $value['created']) . DS . date (" Y-m-d H:i:s", $value['modified']); ?></td>
                                <td class='actions'>
                                    <a class="btn btn-small btn-danger" onclick="del('<?php echo $value['id']; ?>')">Remove</a>
                                    <a class="btn btn-small btn-primary" href="<?php echo $action_edit; ?>?id=<?php echo $value['guid']; ?>" target="new">View Admin</a>
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
<!--                <a href="<?php echo $action_add; ?>" class="btn btn-primary">New Admin</a>-->
            </div>
        </div>
    </div>
</div>
<?php echo $this->element("action_del", array ("plugin"=>"Admin", "actionUrl" => $action_delete, "form" => "#form-filter", "message" => "Are you sure to remove this administrator")); ?>
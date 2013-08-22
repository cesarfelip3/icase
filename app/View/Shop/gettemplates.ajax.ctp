<?php if (false) : ?>
<div class="btn-group">
    <a class="btn dropdown-toggle btn-large btn-info" data-toggle="dropdown" href="#">
        Select Your Product
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" id="template-list">
        <?php foreach ($data as $key => $value) : ?>
            <li>
                <a tabindex="-1" href="javascript:" 
                   data-fg="<?php echo $this->webroot . "img/template/" . $value['Product']['foreground']; ?>" 
                   data-bg="<?php echo $this->webroot . "img/template/" . $value['Product']['background']; ?>" 
                   data-price="<?php echo $value['Product']['price']; ?>" 
                   data-guid="<?php echo $value['Product']['guid']; ?>">
                       <?php echo $value['Product']['name']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
<ul class="nav nav-list" id="template-list">
    <?php foreach ($data as $key => $value) : ?>
        <li style="border-bottom:1px solid #ccc">
            <a tabindex="-1" href="javascript:" 
               data-fg="<?php echo $this->webroot . "img/template/" . $value['Product']['foreground']; ?>" 
               data-bg="<?php echo $this->webroot . "img/template/" . $value['Product']['background']; ?>" 
               data-price="<?php echo $value['Product']['price']; ?>" 
               data-guid="<?php echo $value['Product']['guid']; ?>"
               style="text-transform: uppercase;">
                   <?php echo $value['Product']['name']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
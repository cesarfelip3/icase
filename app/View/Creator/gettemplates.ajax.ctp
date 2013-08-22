
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
            <img src="<?php echo $this->webroot . "img/template/" . $value['Product']['foreground']; ?>" style="width:0px;height:0px;display:none;"/>
            <img src="<?php echo $this->webroot . "img/template/" . $value['Product']['background']; ?>" style="width:0px;height:0px;display:none;"/>
        </li>
    <?php endforeach; ?>
</ul>
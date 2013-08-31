<div class="row-fluid">
    <div class="span12 category_right">
        <?php
        $i = 0;
        $j = 0;
        ?>
        <?php if (!empty($data)) : ?>
            <?php for ($i = 0; $i < count($data); $i += 4) : ?>
                <div class="row-fluid" style='margin-top:20px;'>
                    <?php if (isset($data[$i])) : ?>
                        <div class="span3 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i]['Product']['featured']['150w'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i]['Product']['slug']; ?>" class="prop-title" target="new" style="text-transform: uppercase"><?php echo $data[$i]['Product']['name']; ?></a>

                                    <p class="price">$<?php echo $data[$i]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i]['Product']['slug']; ?>" target="new">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($data[$i + 1])) : ?>
                        <div class="span3 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i + 1]['Product']['featured']['150w'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>" class="prop-title" style="text-transform: uppercase"><?php echo $data[$i + 1]['Product']['name']; ?></a>

                                    <p class="price">$<?php echo $data[$i + 1]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 1]['Product']['slug']; ?>" target="new">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($data[$i + 2])) : ?>
                        <div class="span3 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i + 2]['Product']['featured']['150w'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>" class="prop-title" style="text-transform: uppercase"><?php echo $data[$i + 2]['Product']['name']; ?></a>

                                    <p class="price">$<?php echo $data[$i + 2]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 2]['Product']['slug']; ?>" target="new">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($data[$i + 3])) : ?>
                        <div class="span3 set-equal-heights-js">
                            <div class="thumbnail">
                                <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 3]['Product']['slug']; ?>"><img src="<?php echo $this->webroot; ?>uploads/product/<?php echo $data[$i + 3]['Product']['featured']['150w'][0]; ?>" alt="Placeholder" class=""></a>
                                <div class="caption">
                                    <a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 3]['Product']['slug']; ?>" class="prop-title" style="text-transform: uppercase"><?php echo $data[$i + 3]['Product']['name']; ?></a>

                                    <p class="price">$<?php echo $data[$i + 3]['Product']['price']; ?></p>

                                    <ul class="list-btns">
                                        <li><a href="<?php echo $this->webroot; ?>product/<?php echo $data[$i + 3]['Product']['slug']; ?>" target="new">View Details</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        <?php else :  ?>
        <div>
            <h1>Sorry, we don't have these products yet.</h1>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php if (!empty ($data) && $pagenation == 1) : ?>
<div class="row-fluid">
    <div class="span11">
        <div class="pagination pull-right">
            <ul>
                <li><a href="<?php echo $this->webroot . "search/$keywords?page=" . ($page > 1 ? $page - 1 : 0); ?>">Prev</a></li>
                <?php $min = $page - 5; $max = $page + 5; ?>
                <?php $min = $min < 0 ? 0 : $min; $max = $max > $pages ? $pages : $max; ?>
                <?php for ($i = $min; $i < $max; ++$i) : ?>
                    <li <?php if ($i == $page) echo 'class="active"'; ?>><a href="<?php echo $this->webroot . "search/$keywords?page=$i"; ?>"><?php echo $i + 1; ?></a></li>
                <?php endfor; ?>
                <li><a href="<?php echo $this->webroot . "search/$keywords?page=" . ($page < $pages - 1 ? $page + 1 : $pages - 1); ?>">Next</a></li>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

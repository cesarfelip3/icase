<?php
$template_path = $this->webroot . "uploads/template/";
?>

<ul class="thumbnails">
	<?php foreach ($data as $key => $value) : ?>
	<li class="span3" id="li-template-box" . <?php echo $key + 1; ?>>
		<?php foreach ($value as $val): $val = $val['Template']; ?>
		<div class="thumbnail" style="margin-bottom:5px;">
			<a href="javascript:" data-image-front="<?php echo $template_path . $val['featured'][0];?>" data-image-reverse="<?php echo $template_path . $val['featured'][1];?>" data-guid="<?php echo $val['guid'];?>" data-name="<?php echo $val['name']; ?>"> <img src="<?php echo $template_path . $val['thumbnails'][0];?>"  style=""/> </a>
			<div class="caption">
				<h4><?php echo $val['name']; ?></h4>
			</div>
		</div>
		<?php endforeach; ?>
	</li>
	<?php endforeach; ?>
</ul>
<table cellpadding="0" cellspacing="0">
<?php echo $this->element('table_header', array('keys'=>array('id', 'title', 'slug','created', 'modified')), array('plugin'=>'ActiveAdmin')); ?>
  <?php
  $i = 0;
  foreach ($posts as $post):
    $class = null;
    if ($i++ % 2 == 0) {
      $class = ' class="even"';
    }
  ?>
  <tr<?php echo $class;?>>
    <td><?php echo $post['Post']['id']; ?>&nbsp;</td>
    <td><?php echo $post['Post']['title']; ?>&nbsp;</td>
    <td><?php echo $post['Post']['slug']; ?>&nbsp;</td>
    <td><?php echo $post['Post']['created']; ?>&nbsp;</td>
    <td><?php echo $post['Post']['modified']; ?>&nbsp;</td>
    <td class="actions">
      <?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id'])); ?>
      <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $post['Post']['id'])); ?>
      <?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $post['Post']['id']), null, __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?>
    </td>
  </tr>
<?php endforeach; ?>
</table>
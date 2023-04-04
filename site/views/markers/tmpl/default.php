<?php
/**
 * @version     1.0.0
 * @package     com_marker
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Thanh Hà Nguyễn <thanhha.humg@gmail.com> - http://www.facebook.com/thanhhattd
 */
// no direct access
defined('_JEXEC') or die;
?>
<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_MARKER_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-marker-delete-' + item_id).submit();
        }
    }
</script>

<style type="text/css">
.text_inside{
border:1px;
text-align:center;
}
.items_container{
height:auto;
width:auto;
}
</style>
<div style="text-align:center"><h2><?php echo JText::_('List of Markers'); ?></h2></div>

</script>
<div class="fluid-container" style="width:100%" >
	<table class="table table-hover table-bordered" >
        <thead>
          <tr>
	            <th style="text-align:center">STT</th>
	            <th style="text-align:center"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_TITLE'); ?></th>
	            <th style="text-align:center"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_LATITUDE'); ?></th>
	      		<th style="text-align:center"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_LONGTITUDE'); ?></th>
	      		<th style="text-align:center"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_ALTITUDE'); ?></th>
	      		<th style="text-align:center"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_CATEGORY'); ?></th>
	      		<th style="text-align:center"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_LOCATION'); ?></th>
	      		<th style="text-align:center"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_DESCRIPTION'); ?></th>
	      		<th style="text-align:center">Publish</th>
	      		<th style="text-align:center">Delete</th>
          </tr>
        </thead>
<tbody>
<?php 
$show = false;
if (isset($_GET["limitstart"])) {
  # code...
  // echo $_GET["limitstart"];
  $i=$_GET["limitstart"];
}
else
{
  $i=0;
}
?>
        <?php foreach ($this->items as $item) : ?>

            
				<?php
					if($item->state == 1 || ($item->state == 0 && JFactory::getUser()->authorise('core.edit.own',' com_marker'))):
						$show = true;
						?>

          <tr>
			<td style="text-align:center"><?php echo ++$i;?></td>
            <td style="text-align:center"><a href="<?php echo JRoute::_('index.php?option=com_marker&view=marker&id=' . (int)$item->id); ?>"><?php echo $item->title; ?></a></td>
            <td style="text-align:center"><a href="<?php echo JRoute::_('index.php?option=com_marker&view=marker&id=' . (int)$item->id); ?>"><?php echo $item->latitude; ?></a></td>
            <td style="text-align:center"><a href="<?php echo JRoute::_('index.php?option=com_marker&view=marker&id=' . (int)$item->id); ?>"><?php echo $item->longtitude; ?></a></td>
			<td style="text-align:center"><a href="<?php echo JRoute::_('index.php?option=com_marker&view=marker&id=' . (int)$item->id); ?>"><?php echo $item->altitude; ?></a></td>
			<td style="text-align:center"><a href="<?php echo JRoute::_('index.php?option=com_marker&view=marker&id=' . (int)$item->id); ?>"><?php echo $item->category; ?></a></td>
			<td style="text-align:center"><a href="<?php echo JRoute::_('index.php?option=com_marker&view=marker&id=' . (int)$item->id); ?>"><?php echo $item->location; ?></a></td>
            <td style="text-align:center"><a href="<?php echo JRoute::_('index.php?option=com_marker&view=marker&id=' . (int)$item->id); ?>"><?php echo $item->description; ?></a></td>
            <td  style="text-align:center"><?php
									if(JFactory::getUser()->authorise('core.edit.state','com_marker')):
									?>
										<a class="btn btn-primary" href="javascript:document.getElementById('form-marker-state-<?php echo $item->id; ?>').submit()"><?php if($item->state == 1): echo JText::_("COM_MARKER_UNPUBLISH_ITEM"); else: echo JText::_("COM_MARKER_PUBLISH_ITEM"); endif; ?></a>
										<form id="form-marker-state-<?php echo $item->id ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_marker&task=marker.save'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="jform[state]" value="<?php echo (int)!((int)$item->state); ?>" />
											<input type="hidden" name="option" value="com_marker" />
											<input type="hidden" name="task" value="marker.publish" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
									<?php
									endif;?>
			</td>
            <td style="text-align:center"><?php 
            						if(JFactory::getUser()->authorise('core.delete','com_marker')):
									?>
									<!-- <a class="btn btn-primary" href="javascript:document.getElementById('form-marker-delete-<?php echo $this->item->id ?>').submit()"><?php echo JText::_("COM_MARKER_DELETE_ITEM"); ?></a> -->
									<a class="btn btn-primary" href="javascript:deleteItem(<?php echo $item->id; ?>);"><?php echo JText::_("COM_MARKER_DELETE_ITEM"); ?></a>
										<form id="form-marker-delete-<?php echo $item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_marker&task=marker.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
											<input type="hidden" name="jform[id]" value="<?php echo $item->id; ?>" />
											<input type="hidden" name="option" value="com_marker" />
											<input type="hidden" name="task" value="marker.remove" />
											<?php echo JHtml::_('form.token'); ?>
										</form>
								<?php
								endif;
								?>

            </td>
          </tr>

<?php endif; ?>

<?php endforeach; ?>
<?php
if (!$show):
	echo JText::_('COM_MARKER_NO_ITEMS');
endif;
?>
</tbody>
      </table>
</div>
<?php 
if(JFactory::getUser()->authorise('core.create','com_marker')): 
?>
<div style="text-align:center">
<?php 
if(JFactory::getUser()->authorise('core.create','com_marker')): ?><a href="<?php echo JRoute::_('index.php?option=com_marker&task=marker.edit&id=0'); ?>" class="btn btn-primary"><?php echo JText::_("COM_MARKER_ADD_ITEM"); ?></a>
    <?php endif; ?>
<?php if(JFactory::getUser()->authorise('core.create','com_marker')): ?><a href="<?php echo JRoute::_('index.php?option=com_marker&view=markers&layout=import'); ?>" class="btn btn-primary"><?php echo JText::_("COM_MARKER_IMPORT_ITEM"); ?></a>
    <?php endif; ?>
</div>
<?php 
endif; 
?>
<?php if ($show): ?>
<div class="pagination">
	<p class="counter"><?php echo $this->pagination->getPagesCounter(); ?></p>
<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<?php endif; ?>

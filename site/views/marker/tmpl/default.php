<?php
/**
 * @version     1.0.2
 * @package     com_marker
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Thanh Hà Nguyễn <thanhha.humg@gmail.com> - http://www.facebook.com/thanhhattd
 */
// no direct access
defined('_JEXEC') or die;

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_marker', JPATH_ADMINISTRATOR);
$canEdit = JFactory::getUser()->authorise('core.edit', 'com_marker');
if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_marker')) {
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>
<?php if ($this->item) : ?>
<div class="fluid-container" style="width:100%" >
	<table class="table table-hover table-bordered" >
    	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_STATE'); ?></th>
	    <td><?php echo $this->item->state; ?></td>
	  	</tr>
	  	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_CREATED_BY'); ?></th>
	    <td><?php echo $this->item->created_by_name; ?></td>
	  	</tr>
	  	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_TITLE'); ?></th>
	    <td><?php echo $this->item->title; ?></td>
	  	</tr>
	  	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_LATITUDE'); ?></th>
	    <td><?php echo $this->item->latitude; ?></td>
	  	</tr>
	  	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_LONGTITUDE'); ?></th>
	    <td><?php echo $this->item->longtitude; ?></td>
	  	</tr>
	  	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_ALTITUDE'); ?></th>
	    <td><?php echo $this->item->altitude; ?></td>
	  	</tr>
	  	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_CATEGORY'); ?></th>
	    <td><?php echo $this->item->category; ?></td>
	  	</tr>
	  	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_LOCATION'); ?></th>
	    <td><?php echo $this->item->location; ?></td>
	  	</tr>
	  	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_DESCRIPTION'); ?></th>
	    <td><?php echo $this->item->description; ?></td>
	  	</tr>
	  	<tr>
	    <th scope="row"><?php echo JText::_('COM_MARKER_FORM_LBL_MARKER_IMAGES'); ?></th>
	    <?php if($this->item->images=="") echo "<td>No images!</td>"; else {?>
	    <td><img src="<?php echo $this->item->images; ?>" height="300px" /></td>
	    <?php
	    	}
	    ?>
	  	</tr>
</table>
</div>
    <?php if($canEdit && $this->item->checked_out == 0): ?>
		<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_marker&task=marker.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_MARKER_EDIT_ITEM"); ?></a>
	<?php endif; ?>
								<?php if(JFactory::getUser()->authorise('core.delete','com_marker')):
								?>
									<a class="btn btn-primary" href="javascript:document.getElementById('form-marker-delete-<?php echo $this->item->id ?>').submit()"><?php echo JText::_("COM_MARKER_DELETE_ITEM"); ?></a>
									<form id="form-marker-delete-<?php echo $this->item->id; ?>" style="display:inline" action="<?php echo JRoute::_('index.php?option=com_marker&task=marker.remove'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
										<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
										<input type="hidden" name="option" value="com_marker" />
										<input type="hidden" name="task" value="marker.remove" />
										<?php echo JHtml::_('form.token'); ?>
									</form>
								<?php
								endif;
							?>
							
							<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_marker&view=markers') ?>"><?php echo JText::_("Back"); ?></a>
							
<?php
else:
    echo JText::_('COM_MARKER_ITEM_NOT_LOADED');
endif;
?>

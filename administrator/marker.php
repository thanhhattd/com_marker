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

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_marker')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Marker');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

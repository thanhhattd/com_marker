<?php
/**
 * @version     1.0.2
 * @package     com_marker
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Thanh Hà Nguyễn <thanhha.humg@gmail.com> - http://www.facebook.com/thanhhattd
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Marker controller class.
 */
class MarkerControllerMarker extends JControllerForm
{

    function __construct() {
        $this->view_list = 'markers';
        parent::__construct();
    }

}
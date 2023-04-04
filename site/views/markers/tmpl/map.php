<?php
/**
 * @version     1.0.1
 * @package     com_marker
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Thanh Hà Nguyễn <thanhha.humg@gmail.com> - http://www.facebook.com/thanhhattd
 */
// no direct access
defined('_JEXEC') or die;

JHtml::_('bootstrap.framework');
JHtml::_('jquery.framework');
JHtml::_('jquery.ui');
$assetUrl = JURI::root().'components/com_marker/assets/';
$document= &JFactory::getDocument();
// $document->addScript('http://maps.google.com/maps/api/js?sensor=true&language=en');
$document->addScript('http://maps.google.com/maps/api/js?key=AIzaSyCfBJsyTuTu2sSZL0_ie5ur-0h-1NZ9igw&sensor=true&language=vi');

$document->addScript($assetUrl.'js/markerclusterer.min.js');
$document->addScript($assetUrl.'js/jquery.ui.map.min.js');
?>

<style>
#map-container {
    padding: 4px;
    border-width: 1px;
    border-style: solid;
    border-color: #ccc #ccc #999 #ccc;
    -webkit-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
    -moz-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
    box-shadow: rgba(64, 64, 64, 0.1) 0 2px 5px;
    width: 100%;
    height: 460px;
}
#map_canvas{
    margin:0;
    padding:0;
    width:100%;
    height:450px;
}
</style>
<?php echo JHtml::_('form.token'); ?>
<script type="text/javascript">
    function deleteItem(item_id){
        if(confirm("<?php echo JText::_('COM_MARKER_DELETE_MESSAGE'); ?>")){
            document.getElementById('form-marker-delete-' + item_id).submit();

        }
    }
    function editItem(item_id){
        window.open('index.php?option=com_marker&task=marker.edit&id='+item_id,'_parent');
    }
	jQuery(document).ready(function($)
	{
		// alert('load done!');
		var center= new google.maps.LatLng(21.029071,105.855761);
		var data = <?php echo json_encode($this->items ); ?>;
		$('#map_canvas').gmap(
            {
                'center':center,
                'draggable':true,
                'zoomControl':true,
                'panControl':true,
                'scaleControl':true,
                'streetViewControl':false,
                'mapTypeControl': true,
                'zoom': 10,
                'callback': function(){
        			var self=this;
        			var map=self.get('map');
        			
        			//add marker
        			$.each(data,function(i,markerData)
        			{
        				if(markerData.state==1)
        				{
        					var latLng= new google.maps.LatLng(markerData.latitude, markerData.longtitude);
        					self.addMarker(
        					{
        						'id': markerData.id,
        						'state':markerData.state,
        						'title': markerData.title,
        						'position':latLng,
        						'description':markerData.description,
        						'images':markerData.images,
        						'bounds':true
        					}, function(map,marker) {}).click(function() 
        					{
        						var marker=$(this)[0];
        						var title = markerData.title;
        						var desc = '<br/>Description: ' + markerData.description;
                                var lat = markerData.latitude;
        						var lon = markerData.longtitude;

                                if (markerData.altitude!="") {
                                    var alt = '<br/>Altitude: ' + markerData.altitude;
                                }
                                else var alt="";
                                if (markerData.category!="") {
                                    var category = '<br/>Category: ' + markerData.category;
                                }
                                else var category="";
                                if (markerData.location!="") {
                                    var location = '<br/>Location: ' + markerData.location;
                                }
                                else var location="";
                                
                                if (marker.images!="") {
                                    var img='<br/><img src="'+marker.images+'" height="100" width="100"><br/>';
                                }
                                else var img="<br/>No images<br/>";

    							$('#map_canvas').gmap('openInfoWindow', { 
                                    content : 'Title: '
                                    + title
                                    + img 
                                    + 'Lat, Lon: ' + lat + ', ' + lon
                                    + alt
                                    + category
                                    + location
                                    + desc
                                    + '<br/><button type="button" class="btn btn-primary" onclick="editItem(' + marker.id + ')">Edit</button>'
                                    + '   <button type="button" class="btn btn-primary" onclick="deleteItem(' + marker.id + ')">Delete</button>'
                                    + '<form id="form-marker-delete-' + marker.id + '" style="display:inline" action="" method="post" class="form-validate" enctype="multipart/form-data">'
                                    + '<input type="hidden" name="jform[id]" value="'+marker.id+'" />'
                                    + '<input type="hidden" name="option" value="com_marker" />'
                                    + '<input type="hidden" name="task" value="marker.remove" /></form>'
                                }, this);
        					});
        				}

        			});
                    // self.set('MarkerClusterer', new MarkerClusterer(map, self.get('markers')));

    		}});
	});
</script>
<br/>
<div id="map-container">
<div id="map_canvas" ></div>
</div>
<br/>
<div style="text-align:center">
<?php 
if(JFactory::getUser()->authorise('core.create','com_marker')): ?><a href="<?php echo JRoute::_('index.php?option=com_marker&task=marker.edit&id=0'); ?>" class="btn btn-primary"><?php echo JText::_("COM_MARKER_ADD_ITEM"); ?></a>
    <?php endif; ?>
<?php if(JFactory::getUser()->authorise('core.create','com_marker')): ?><a href="<?php echo JRoute::_('index.php?option=com_marker&view=markers&layout=import'); ?>" class="btn btn-primary"><?php echo JText::_("COM_MARKER_IMPORT_ITEM"); ?></a>
    <?php endif; ?>
</div>


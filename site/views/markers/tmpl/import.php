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

//Excel Reader library
include 'Classes/PHPExcel/IOFactory.php';
include 'Classes/Excel_reader.php';

// }
?>
<?php if(JFactory::getUser()->authorise('core.create','com_marker')){ ?>
<form enctype="multipart/form-data" method="post" role="form">
    <div class="form-group">
        <label for="exampleInputFile">File Upload</label>
        <input type="file" name="file" id="file" size="100" class "btn btn-primary"><br/>

        Header <input name="header" type="checkbox" value="1" />

        <p class="help-block">Only Excel/CSV File Import.</p>

    </div>
    <button type="submit" class="btn btn-primary"  name="Import" value="Import" >Upload</button>
</form>

<?php 
//code import file
if(isset($_POST["Import"]))
{
    // Get a db connection.
    $db = JFactory::getDbo();
 
    // Create a new query object.
    $query = $db->getQuery(true);

    if(isset($_POST["header"])) 
    {
        $header=$_POST["header"];
    }
    else
    {
        $header=0;
    }

    echo '<br/>';

    if($_FILES["file"]["type"]=='application/vnd.ms-excel')
    {
        // echo strlen($_FILES["file"]["name"]);
        $type = substr($_FILES["file"]["name"],(strlen($_FILES["file"]["name"])-4),strlen($_FILES["file"]["name"]));
        // echo $type.'<br/>';
        if ($type=='.csv') {
            # code .csv
            // echo '<br/> .csv';
            $filename=$_FILES["file"]["tmp_name"];
            if($_FILES["file"]["size"] > 0)
            {
                $row=0;
                $file = fopen($filename, "r");

                while (($data = fgetcsv($file, 0, ",")) !== FALSE)
                {
                 // $num=count($data);
                     // echo "<p> có $num trường trên mỗi dòng:</p>\n";
                     $row++;
                     // echo $data[0]." - ";
                     // echo $data[1]." - ";
                     // echo $data[2]." - ";
                     // echo $data[3]." - ";
                     // echo $data[4]." - ";
                     // echo $data[5]."<br/>";
                    if($row>$header)
                    {                                  
                        // Create and populate an object.
                        $markerData = new stdClass();
                        $markerData->created_by = JFactory::getUser()->id;
                        $markerData->state=1;
                        $markerData->title = $data[0];
                        $markerData->latitude= $data[1];
                        $markerData->longtitude= $data[2];
                        $markerData->altitude= $data[3];
                        $markerData->category= $data[4];
                        $markerData->location= $data[5];
                        $markerData->description=$data[6];
                         
                        // Insert the object into the user markerData table.
                        $result = JFactory::getDbo()->insertObject('#__gmap_marker', $markerData);
                    }  
                }
                fclose($file);
                echo 'CSV File has been successfully Imported';
                ?>
                <a href="<?php echo JRoute::_('index.php?option=com_marker&view=markers&layout=map'); ?>"><?php echo '<br/>Back to Map view<br/>' ?></a>
                <a href="<?php echo JRoute::_('index.php?option=com_marker&view=markers'); ?>"><?php echo '<br/>Back to List view' ?></a>
                <?php
            }
            else
                echo 'Invalid: File is empty';
        } 
        elseif ($type=='.xls') {
            # code .xls
            
            if($_FILES["file"]["size"] > 0)
            {
                // echo '<br/> excel 2003';
                $inputFileName = $_FILES["file"]["tmp_name"];

                // khoi tao doi tuong doc file excel 2003
                $data = new Spreadsheet_Excel_Reader($inputFileName,true,"UTF-8");

                $rowsnum = $data->rowcount($sheet_index=0); // lay so hang cua sheet
                $colsnum =  $data->colcount($sheet_index=0); // lay so cot cua sheet
                $total=$rowsnum-$header;
                for ($row=1;$row<=$rowsnum;$row++)
                {
                    if ($row>$header) 
                    {
                        // echo $data->val($row,1);
                        // echo $data->val($row,2);
                        // echo $data->val($row,3);
                        // echo $data->val($row,4);
                        // echo $data->val($row,5);
                          // Create and populate an object.
                        $markerData = new stdClass();
                        $markerData->created_by = JFactory::getUser()->id;
                        $markerData->state=1;
                        $markerData->title = $data->val($row,1);
                        $markerData->latitude= $data->val($row,2);
                        $markerData->longtitude= $data->val($row,3);
                        $markerData->altitude= $data->val($row,4);
                        $markerData->category= $data->val($row,5);
                        $markerData->location= $data->val($row,6);
                        $markerData->description= $data->val($row,7);
                         
                        // Insert the object into the user markerData table.
                        $result = JFactory::getDbo()->insertObject('#__gmap_marker', $markerData);
                    } 
                }
                // echo 'Excel 2003 File has been successfully Imported';
                echo $total .' records were added - Excel 2003 File has been successfully Imported';
                ?>
                    <a href="<?php echo JRoute::_('index.php?option=com_marker&view=markers&layout=map'); ?>"><?php echo '<br/>Back to Map view<br/>' ?></a>
                    <a href="<?php echo JRoute::_('index.php?option=com_marker&view=markers'); ?>"><?php echo '<br/>Back to List view' ?></a>
                <?php
            }
            else
                echo 'Invalid: File is empty';
        }
    }
    elseif($_FILES["file"]["type"]=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
    {
        /** Include path **/
        //set_include_path('Classes/');

        /** PHPExcel_IOFactory */


        $inputFileType = 'Excel2007';
        $inputFileName = $_FILES["file"]["tmp_name"];

        /**  Create a new Reader of the type defined in $inputFileType  **/
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a PHPExcel Object  **/
        $objPHPExcel = $objReader->load($inputFileName);

        if($_FILES["file"]["size"] > 0)
        {
            $objReader->setReadDataOnly(true);
            $objWorksheet = $objPHPExcel->getActiveSheet();

            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();
            $total=$highestRow-$header;

            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

            for ($row=1; $row <= $highestRow; ++$row) 
            {
                if ($row>$header) 
                {
                    // for ($col = 0; $col < $highestColumnIndex; ++$col) 
                    // {
                    //     echo $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . ' - ';
                    // }

                    // Create and populate an object.
                    $markerData = new stdClass();
                    $markerData->created_by = JFactory::getUser()->id;
                    $markerData->state=1;
                    $markerData->title = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $markerData->latitude= $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $markerData->longtitude= $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $markerData->altitude= $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $markerData->category= $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $markerData->location= $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $markerData->description=$objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
                     
                    // Insert the object into the user markerData table.
                    $result = JFactory::getDbo()->insertObject('#__marker_marker', $markerData);
                }
            }
            // echo 'Excel 2007 File has been successfully Imported';
            echo $total .' records were added - Excel 2007 File has been successfully Imported';
            ?>
                <a href="<?php echo JRoute::_('index.php?option=com_marker&view=markers&layout=map'); ?>"><?php echo '<br/>Back to Map view<br/>' ?></a>
                <a href="<?php echo JRoute::_('index.php?option=com_marker&view=markers'); ?>"><?php echo '<br/>Back to List view' ?></a>
            <?php
        }
        else
            echo 'Invalid: File is empty';

    } else 
        echo 'Invalid File: Please Upload CSV/Excel File';
}
?>
<?php 
}
else {
    include JRoute::_('index.php?option=com_users&view=login');
    ?>
        <a href="<?php echo JRoute::_('index.php?option=com_users&view=login'); ?>"><?php echo '<br/>Please Login for Uploading files!' ?></a>
    <?php 
}
?>
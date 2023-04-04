<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
// error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Ho_Chi_Minh');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Thanh Ha Nguyen")
							 ->setLastModifiedBy("Thanh Ha Nguyen")
							 ->setTitle("Office 2007 XLSX Markers Database Exported")
							 ->setSubject("Office 2007 XLSX Markers Database Exported")
							 ->setDescription("Markers Database Exported for Office 2007 XLSX.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Markers");


$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Title')
            ->setCellValue('B1', 'Latitude')
            ->setCellValue('C1', 'Longtitude')
            ->setCellValue('D1', 'Altitude')
            ->setCellValue('E1', 'Category')
            ->setCellValue('F1', 'Location')
            ->setCellValue('G1', 'Description');
// Add some data
$row=1;
foreach ($this->items as $item) :
	++$row;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$row, $item->title)
            ->setCellValue('B'.$row, $item->latitude)
            ->setCellValue('C'.$row, $item->longtitude)
            ->setCellValue('D'.$row, $item->altitude)
            ->setCellValue('E'.$row, $item->category)
            ->setCellValue('F'.$row, $item->location)
            ->setCellValue('G'.$row, $item->description);
endforeach;

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Markers');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="markers_'.date('dmY_His').'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
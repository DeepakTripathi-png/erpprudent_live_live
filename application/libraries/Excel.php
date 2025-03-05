<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
require_once APPPATH."/third_party/PHPExcel.php"; 
 
class Excel extends PHPExcel { 
    public function __construct() {  
        parent::__construct(); 
        $CI =& get_instance();
    } 
public function delivery_challan_note($delivery_challan_data,$delivery_challan_items_data,$consignee_data){
    $work_order_on =  (isset($delivery_challan_data[0]->work_order_on) && !empty($delivery_challan_data[0]->work_order_on) && $delivery_challan_data[0]->work_order_on == 'Prudent EPC')?'Prudent EPC':'Prudent Controls';
    if($work_order_on == 'Prudent EPC'){
        $companynamef = 'Prudent EPC Private Limited';
    }else{
        $companynamef = 'Prudent Controls Private Limited';    
    }
	$excelname='DELIVERY NOTE';
    $CI =& get_instance(); 
    $CI->load->model('common_model');
    $CI->load->library('excel');
    PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder());
    $CI->excel->getProperties()->setCreator("prudent")->setLastModifiedBy("prudent")->setTitle($excelname)
    ->setSubject($excelname)->setDescription("System Generated File.")->setKeywords("office 2007")->setCategory("Confidential");
    $allborders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $allbordersthk = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $rightBorderStyle = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $rightBorderStylethk = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $leftBorderStylethk = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    $leftBorderStyle = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    
    $topBorderStyle = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $topBorderStylethk = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $bottomBorderStyle = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $bottomBorderStylethk = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $CI->excel->setActiveSheetIndex(0);
	$CI->excel->getActiveSheet()->getStyle("A1:L1")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A1:L1') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
	$CI->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$CI->excel->getActiveSheet()->setCellValue('A1','DELIVERY NOTE');
	$CI->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
	$CI->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	
	$CI->excel->getActiveSheet()->getStyle("A2:D2")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A2:D2') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A2',$companynamef);
	
	$CI->excel->getActiveSheet()->getStyle("E2:H2")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E2:H2') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E2:H2')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E2:H2')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E2:H2')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E2:H2')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E2','Delivery Note No');
	
	$dc_no =  (isset($delivery_challan_data[0]->dc_no) && !empty($delivery_challan_data[0]->dc_no))?$delivery_challan_data[0]->dc_no:'';
	$CI->excel->getActiveSheet()->getStyle("I2:L2")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I2:L2') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I2:L2')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I2:L2')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I2:L2')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I2:L2')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I2:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I2',$dc_no);
	
	$CI->excel->getActiveSheet()->getStyle("A3:D3")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A3:D3') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A3:D3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A3','91/B, Opp Vishal Tower 2,');
	
	$CI->excel->getActiveSheet()->getStyle("E3:H3")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E3:H3') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E3:H3')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E3:H3')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E3:H3')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E3:H3')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E3:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E3','');
	
	$CI->excel->getActiveSheet()->getStyle("I3:L3")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I3:L3') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I3:L3')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I3:L3')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I3:L3')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I3:L3')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I3:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I3','');
	
	$CI->excel->getActiveSheet()->getStyle("A4:D4")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A4:D4') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A4:D4')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A4:D4')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A4:D4')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A4:D4')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A4','Kamgar Nagar, Kurla East - 400024');
	
	$CI->excel->getActiveSheet()->getStyle("E4:H4")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E4:H4') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E4:H4')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E4:H4')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E4:H4')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E4:H4')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E4','');
	
	$CI->excel->getActiveSheet()->getStyle("I4:L4")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I4:L4') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I4:L4')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I4:L4')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I4:L4')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I4:L4')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I4','');
	
	$CI->excel->getActiveSheet()->getStyle("A5:D5")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A5:D5') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A5:D5')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A5','');
	
	$suppliers_ref =  (isset($delivery_challan_data[0]->suppliers_ref) && !empty($delivery_challan_data[0]->suppliers_ref))?$delivery_challan_data[0]->suppliers_ref:'';
	$CI->excel->getActiveSheet()->getStyle("E5:H5")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E5:H5') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E5:H5')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E5:H5')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E5:H5')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E5:H5')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E5:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E5',"Supplier's Ref");
	
	$CI->excel->getActiveSheet()->getStyle("I5:L5")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I5:L5') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I5:L5')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I5:L5')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I5:L5')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I5:L5')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I5:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I5',$suppliers_ref);
	
	$CI->excel->getActiveSheet()->getStyle("A6:D6")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A6:D6') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A6:D6')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A6:D6')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A6:D6')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A6:D6')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A6:D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A6','Consignee');
	
	$consignee_name =  (isset($consignee_data[0]->consignee_name) && !empty($consignee_data[0]->consignee_name))?$consignee_data[0]->consignee_name:'';
	$CI->excel->getActiveSheet()->getStyle("E6:F6")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E6:F6') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E6:F6')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E6:F6')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E6:F6')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E6:F6')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E6:F6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E6',"");
	
	$delivery_address =  (isset($consignee_data[0]->delivery_address) && !empty($consignee_data[0]->delivery_address))?$consignee_data[0]->delivery_address:'';
	$CI->excel->getActiveSheet()->getStyle("G6:H6")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G6:H6') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('G6:H6')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('G6:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('G6',"");
	
	$CI->excel->getActiveSheet()->getStyle("I6:J6")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I6:J6') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I6:J6')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I6:J6')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I6:J6')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I6:J6')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I6:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I6','');
	
	$CI->excel->getActiveSheet()->setCellValue('K6','');
	$CI->excel->getActiveSheet()->getStyle('K6')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K6')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K6')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K6')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('L6','');
	$CI->excel->getActiveSheet()->getStyle('L6')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L6')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L6')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L6')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getStyle("A7:D7")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A7:D7') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A7:D7')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A7:D7')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A7:D7')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A7:D7')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A7:D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A7',$consignee_name);
	
	$buyer_order_ref =  (isset($delivery_challan_data[0]->buyer_order_ref) && !empty($delivery_challan_data[0]->buyer_order_ref))?$delivery_challan_data[0]->buyer_order_ref:'';
	$CI->excel->getActiveSheet()->getStyle("E7:H7")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E7:H7') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E7:H7')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E7:H7')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E7:H7')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E7:H7')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E7:H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E7',"Buyer's Order Ref");
	
	$dccdate =  (isset($delivery_challan_data[0]->dcc_dated) && !empty($delivery_challan_data[0]->dcc_dated))?date('d-m-Y',strtotime($delivery_challan_data[0]->dcc_dated)):'';
	$CI->excel->getActiveSheet()->setCellValue('I7','Dated');
	$CI->excel->getActiveSheet()->getStyle('I7')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I7')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I7')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I7')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getStyle("J7:L7")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J7:L7') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('J7:L7')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J7:L7')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J7:L7')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J7:L7')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J7:L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('J7',$dccdate);
	
	$CI->excel->getActiveSheet()->getStyle("A8:D11")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A8:D11') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A8:D11')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A8:D11')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A8:D11')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A8:D11')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A8:D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A8',$delivery_address);
	
	$CI->excel->getActiveSheet()->getStyle("E8:L8")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E8:L8') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E8:L8')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E8:L8')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E8:L8')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E8:L8')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E8:L8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E8',$buyer_order_ref);
	
	$dispatch_document_no =  (isset($delivery_challan_data[0]->dispatch_document_no) && !empty($delivery_challan_data[0]->dispatch_document_no))?$delivery_challan_data[0]->dispatch_document_no:'';
	$CI->excel->getActiveSheet()->getStyle("E9:H11")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E9:H11') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E9:H11')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E9:H11')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E9:H11')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E9:H11')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E9:H11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$dispatch_document_notxt = "Dispatch Document No: \r\n".$dispatch_document_no;
	$CI->excel->getActiveSheet()->setCellValue('E9',$dispatch_document_notxt);
	$CI->excel->getActiveSheet()->getStyle("E9")->getAlignment()->setWrapText(true);
	
	$CI->excel->getActiveSheet()->getStyle("I9:L9")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I9:L9') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I9:L9')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I9:L9')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I9:L9')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I9:L9')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I9:L9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I9','Destination');
	
	$destination =  (isset($delivery_challan_data[0]->destination) && !empty($delivery_challan_data[0]->destination))?$delivery_challan_data[0]->destination:'';
	$CI->excel->getActiveSheet()->getStyle("I10:L11")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I10:L11') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I10:L11')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I10:L11')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I10:L11')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I10:L11')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I10:L11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I10',$destination);
	
	$CI->excel->getActiveSheet()->getStyle("A12:D12")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A12:D12') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A12:D12')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A12:D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A12','Buyer (Other than Consignee)');
	
	$consignee_buyer =  (isset($delivery_challan_data[0]->consignee_buyer) && !empty($delivery_challan_data[0]->consignee_buyer))?$delivery_challan_data[0]->consignee_buyer:'';
	$CI->excel->getActiveSheet()->getStyle("E12:F12")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E12:F12') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E12:F12')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E12:F12')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E12:F12')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E12:F12')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E12:F12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E12','');
	
	$CI->excel->getActiveSheet()->getStyle("G12:H12")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G12:H12') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G12:H12')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('G12:H12')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('G12:H12')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('G12:H12')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('G12:H12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('G12','');
	
	$CI->excel->getActiveSheet()->getStyle("I12:J12")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I12:J12') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I12:J12')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I12:J12')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I12:J12')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I12:J12')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I12:J12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I12','');
	
	$CI->excel->getActiveSheet()->setCellValue('K12','');
	$CI->excel->getActiveSheet()->getStyle('K12')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K12')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K12')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K12')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('L12','');
	$CI->excel->getActiveSheet()->getStyle('L12')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L12')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L12')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L12')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getStyle("A13:D13")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A13:D13') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A13:D13')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A13:D13')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A13:D13')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A13:D13')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A13:D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A13',$consignee_buyer);
	
	$CI->excel->getActiveSheet()->getStyle("E13:H13")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E13:H13') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E13:H13')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E13:H13')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E13:H13')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E13:H13')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E13:H13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$dispatch_document_trxt = "Dispatched Through: \r\n".$dispatch_through;
	$CI->excel->getActiveSheet()->setCellValue('E13',$dispatch_document_trxt);
	$CI->excel->getActiveSheet()->getStyle("E13")->getAlignment()->setWrapText(true);
	
	$dispatch_through =  (isset($delivery_challan_data[0]->dispatch_through) && !empty($delivery_challan_data[0]->dispatch_through))?$delivery_challan_data[0]->dispatch_through:'';
	$CI->excel->getActiveSheet()->getStyle("I13:J13")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I13:J13') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I13:J13')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I13:J13')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I13:J13')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I13:J13')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I13:J13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I13','');
	
	$CI->excel->getActiveSheet()->setCellValue('K13','');
	$CI->excel->getActiveSheet()->getStyle('K13')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K13')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K13')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K13')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('L13','');
	$CI->excel->getActiveSheet()->getStyle('L13')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L13')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L13')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L13')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getStyle("A14:D16")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A14:D16') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A14:D16')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A14:D16')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A14:D16')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A14:D16')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A14:D16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A14','');
	
	$CI->excel->getActiveSheet()->getStyle("E14:H14")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E14:H14') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E14:H14')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E14:H14')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E14:H14')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E14:H14')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E14:H14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E14','');
	
	$CI->excel->getActiveSheet()->getStyle("I14:J14")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I14:J14') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I14:J14')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I14:J14')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I14:J14')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I14:J14')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I14:J14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I14','');
	
	$CI->excel->getActiveSheet()->setCellValue('K14','');
	$CI->excel->getActiveSheet()->getStyle('K14')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K14')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K14')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K14')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('L14','');
	$CI->excel->getActiveSheet()->getStyle('L14')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L14')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L14')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('L14')->applyFromArray($bottomBorderStyle);
	
	$terms_of_delivery =  (isset($delivery_challan_data[0]->terms_of_delivery) && !empty($delivery_challan_data[0]->terms_of_delivery))?$delivery_challan_data[0]->terms_of_delivery:'';
	$CI->excel->getActiveSheet()->getStyle("E15:L15")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E15:L15') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E15:L15')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E15:L15')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E15:L15')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E15:L15')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E15:L15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E15','Terms of Delivery');
	
	$CI->excel->getActiveSheet()->getStyle("E16:L16")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E16:L16') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E16:L16')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E16:L16')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E16:L16')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E16:L16')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E16:L16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E16',$terms_of_delivery);
	
	$CI->excel->getActiveSheet()->getStyle("A17:L17")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A17:L17') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A17:L17')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A17:L17')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A17:L17')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A17:L17')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A17:L17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A17','');
	
	$CI->excel->getActiveSheet()->getStyle("A18:B18")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A18:B18') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A18:B18')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A18:B18')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A18:B18')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A18:B18')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A18:B18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A18','Sr No As per BOM');
	
	$CI->excel->getActiveSheet()->getStyle("C18:D18")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('C18:D18') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('C18:D18')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('C18:D18')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('C18:D18')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('C18:D18')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('C18:D18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('C18','Sr No As per BOQ');
	
	$CI->excel->getActiveSheet()->getStyle("E18:H18")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E18:H18') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E18:H18')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E18:H18')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E18:H18')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E18:H18')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E18:H18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E18','Description of Goods');
	
	$CI->excel->getActiveSheet()->getStyle("I18:J18")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I18:J18') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I18:J18')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I18:J18')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I18:J18')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I18:J18')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I18:J18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I18','HSN/SAC Code');
	
	$CI->excel->getActiveSheet()->getStyle("K18:L18")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('K18:L18') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('K18:L18')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K18:L18')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K18:L18')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K18:L18')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K18:L18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('K18','Quantity');
	
	
	if(isset($delivery_challan_items_data) && !empty($delivery_challan_items_data)){
	    $i=19;
	    $j=1;
	    foreach($delivery_challan_items_data as $key){
	        $boq_code =  (isset($key->boq_code) && !empty($key->boq_code))?$key->boq_code:'';
	        $item_description =  (isset($key->item_description) && !empty($key->item_description))?$key->item_description:'';
	        $qty =  (isset($key->qty) && !empty($key->qty))?$key->qty:'0';
	        $hsn_sac_code =  (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code))?$key->hsn_sac_code:'0';

			$estimatedCharactersPerRow = 50; // Adjust this value based on your needs
			$requiredRowHeight = ceil(strlen($item_description) / $estimatedCharactersPerRow);
	        $CI->excel->getActiveSheet()->getRowDimension($i)->setRowHeight($requiredRowHeight * 15);
	        
	        $CI->excel->getActiveSheet()->getStyle("A".$i.":B".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('A'.$i.':B'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->applyFromArray($bottomBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	$CI->excel->getActiveSheet()->setCellValue('A'.$i,$j);
        	
        	$CI->excel->getActiveSheet()->getStyle("C".$i.":D".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('C'.$i.':D'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->applyFromArray($bottomBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	$CI->excel->getActiveSheet()->setCellValue('C'.$i,$boq_code);
        	
        	$CI->excel->getActiveSheet()->getStyle("E".$i.":H".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('E'.$i.':H'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->applyFromArray($bottomBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	$CI->excel->getActiveSheet()->setCellValue('E'.$i,$item_description);
        	
        	$CI->excel->getActiveSheet()->getStyle("I".$i.":J".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('I'.$i.':J'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray($bottomBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	$CI->excel->getActiveSheet()->setCellValue('I'.$i,$hsn_sac_code);
        	
        	$CI->excel->getActiveSheet()->getStyle("K".$i.":L".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('K'.$i.':L'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->applyFromArray($bottomBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	$CI->excel->getActiveSheet()->setCellValue('K'.$i,$qty);
        	$i++;
        	$j++;
	    }
	}else{
	    $i=19;
	    $CI->excel->getActiveSheet()->getStyle("A".$i.":B".$i)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('A'.$i.':B'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->applyFromArray($rightBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->applyFromArray($leftBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->applyFromArray($topBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->applyFromArray($bottomBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('A'.$i.':B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->setCellValue('A'.$i,'');
    	
    	$CI->excel->getActiveSheet()->getStyle("C".$i.":D".$i)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('C'.$i.':D'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->applyFromArray($rightBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->applyFromArray($leftBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->applyFromArray($topBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->applyFromArray($bottomBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('C'.$i.':D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->setCellValue('C'.$i,'');
    	
    	$CI->excel->getActiveSheet()->getStyle("E".$i.":H".$i)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('E'.$i.':H'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->applyFromArray($rightBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->applyFromArray($leftBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->applyFromArray($topBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->applyFromArray($bottomBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('E'.$i.':H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->setCellValue('E'.$i,'');
    	
    	$CI->excel->getActiveSheet()->getStyle("I".$i.":J".$i)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('I'.$i.':J'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray($rightBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray($leftBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray($topBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->applyFromArray($bottomBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('I'.$i.':J'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->setCellValue('I'.$i,'');
    	
    	$CI->excel->getActiveSheet()->getStyle("K".$i.":L".$i)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('K'.$i.':L'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->applyFromArray($rightBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->applyFromArray($leftBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->applyFromArray($topBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->applyFromArray($bottomBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('K'.$i.':L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->setCellValue('K'.$i,'');
    }
	$dccount =  (isset($delivery_challan_items_data) && !empty($delivery_challan_items_data))?count($delivery_challan_items_data) + 19:'20';
	$CI->excel->getActiveSheet()->getStyle("A".$dccount.":D".($dccount+2))->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.$dccount.':D'.($dccount+2)) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.$dccount.':D'.($dccount+2))->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.$dccount.':D'.($dccount+2))->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.$dccount.':D'.($dccount+2))->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.$dccount.':D'.($dccount+2))->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.$dccount.':D'.($dccount+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A'.$dccount,'');
	
	$CI->excel->getActiveSheet()->getStyle("A".($dccount+3).":D".($dccount+3))->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.($dccount+3).':D'.($dccount+3)) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+3).':D'.($dccount+3))->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+3).':D'.($dccount+3))->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+3).':D'.($dccount+3))->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+3).':D'.($dccount+3))->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+3).':D'.($dccount+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A'.($dccount+3),"Buyer's VAT TIN:");
	
	$CI->excel->getActiveSheet()->getStyle("A".($dccount+4).":D".($dccount+4))->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.($dccount+4).':D'.($dccount+4)) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+4).':D'.($dccount+4))->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+4).':D'.($dccount+4))->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+4).':D'.($dccount+4))->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+4).':D'.($dccount+4))->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+4).':D'.($dccount+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A'.($dccount+4),"Company's PAN:");
	
	$CI->excel->getActiveSheet()->getStyle("E".$dccount.":H".($dccount+4))->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('E'.$dccount.':H'.($dccount+4)) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('E'.$dccount.':H'.($dccount+4))->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E'.$dccount.':H'.($dccount+4))->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E'.$dccount.':H'.($dccount+4))->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E'.$dccount.':H'.($dccount+4))->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('E'.$dccount.':H'.($dccount+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('E'.($dccount),'');
	
	$CI->excel->getActiveSheet()->getStyle("I".$dccount.":L".$dccount)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I'.$dccount.':L'.$dccount) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I'.$dccount.':L'.$dccount)->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.$dccount.':L'.$dccount)->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.$dccount.':L'.$dccount)->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.$dccount.':L'.$dccount)->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.$dccount.':L'.$dccount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I'.$dccount,'');
	
	$CI->excel->getActiveSheet()->getStyle("I".($dccount+1).":L".($dccount+4))->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I'.($dccount+1).':L'.($dccount+4)) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+1).':L'.($dccount+4))->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+1).':L'.($dccount+4))->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+1).':L'.($dccount+4))->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+1).':L'.($dccount+4))->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+1).':L'.($dccount+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I'.($dccount+1),'For '.$companynamef);
	
	$CI->excel->getActiveSheet()->getStyle("A".($dccount+5).":H".($dccount+5))->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.($dccount+5).':H'.($dccount+5)) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+5).':H'.($dccount+5))->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+5).':H'.($dccount+5))->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+5).':H'.($dccount+5))->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+5).':H'.($dccount+5))->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+5).':H'.($dccount+5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A'.($dccount+5),'Recd in Good Condition');
	
	$CI->excel->getActiveSheet()->getStyle("I".($dccount+5).":L".($dccount+5))->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('I'.($dccount+5).':L'.($dccount+5)) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+5).':L'.($dccount+5))->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+5).':L'.($dccount+5))->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+5).':L'.($dccount+5))->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+5).':L'.($dccount+5))->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I'.($dccount+5).':L'.($dccount+5))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('I'.($dccount+5),'Authorised Signatory');
	
	$CI->excel->getActiveSheet()->getStyle("A".($dccount+6).":L".($dccount+6))->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.($dccount+6).':L'.($dccount+6)) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+6).':L'.($dccount+6))->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+6).':L'.($dccount+6))->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+6).':L'.($dccount+6))->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+6).':L'.($dccount+6))->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.($dccount+6).':L'.($dccount+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A'.($dccount+6),'This is a Computer Generated Document');
	
	$challan_id=9;
	$filename=$challan_id."_DELIVERY_CHALLAN_NOTE.xls";
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename='.$filename); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	header('Cache-Control: max-age=1');
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header ('Cache-Control: cache, must-revalidate');
	header ('Pragma: public');
	$objWriter = PHPExcel_IOFactory::createWriter($CI->excel, 'Excel5');
	$objWriter->save('php://output'); 
}
public function invoice_format($tax_invc_data,$tax_invc_items_data,$type){
    if($type == 'tax'){
    $excelname='TAX INVOICE FORMAT 2';
    }else{
    $excelname='PROFORMA INVOICE FORMAT 2';
    }
    $CI =& get_instance(); 
    $CI->load->model('common_model');
    $CI->load->library('excel');
    PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder());
    $CI->excel->getProperties()->setCreator("prudent")->setLastModifiedBy("prudent")->setTitle($excelname)
    ->setSubject($excelname)->setDescription("System Generated File.")->setKeywords("office 2007")->setCategory("Confidential");
    $allborders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $allbordersthk = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $rightBorderStyle = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $rightBorderStylethk = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $leftBorderStylethk = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    $leftBorderStyle = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    
    $topBorderStyle = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $topBorderStylethk = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $bottomBorderStyle = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $bottomBorderStylethk = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $CI->excel->setActiveSheetIndex(0);
	$CI->excel->getActiveSheet()->getStyle("A1:L5")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A1:L1') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($allborders);
	$CI->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$bank_name = 'Janakalyan Sahakari Bank Ltd.';
	$ifsccode = 'JSBL0000018';
	$branch_addr = 'Sindhi Society';
	$companyname = '';
	$companynamef = '';
	$gstnoc = $pannoc = $faddr = $fdets = $fweb ='';
	$work_order_on =  (isset($tax_invc_data->work_order_on) && !empty($tax_invc_data->work_order_on) && $tax_invc_data->work_order_on == 'Prudent EPC')?'Prudent EPC':'Prudent Controls';
	if($work_order_on == 'Prudent EPC'){
	$faddr = 'Registered office: 91/B, Kamgar Nagar, Vishal Tower No.2, S.G.Barve Marg, Kurla, Mumbai 400024';
	$fdets = 'CIN : U72900MH2019PTC323399, Land Line: +91 022-25220676';
	$fweb = 'www.prudentepc.com, sales@prudentepc.com';
	$companynamef = 'Prudent EPC Private Limited';
	$bank_acc = '018013500000016';
	$gstnoc='27AAKCP4656L1ZS';
	$pannoc='AAKCP4656L';
	$companyname = 'PRUDENT EPC PRIVATE LIMITED';
// 	$imagePath = '/home3/trackmrg/public_html/prudent/uploads/images/logo2.png';
	$imagePath = base_url().'uploads/images/logo2.png';
	$objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Image');
    $objDrawing->setDescription('Image');
    // $objDrawing->setPath($imagePath);
    $objDrawing->setCoordinates('J2');
    $objDrawing->setWidth(180);
    $objDrawing->setHeight(90);
    $sheet = $CI->excel->getActiveSheet();
    $objDrawing->setWorksheet($sheet);
    }else{
	$faddr = 'Registered Office – 91/B, S G Barve Marg, Kamgar Nagar, Kurla (East), Mumbai-400024';
	$fdets = 'CIN: U72300MH2012PTC229314, Land Line: 022 25220676, 8879650193,';
	$fweb = 'www.prudentcontrols.com';
	$gstnoc='27AAGCP5489F1ZO';
	$pannoc='AAGCP5489F';
	$bank_acc = '018011300001395';
	$companyname = 'PRUDENT CONTROLS PRIVATE LIMITED';
// 	$imagePath = '/home3/trackmrg/public_html/prudent/uploads/images/logo3.png';
	$imagePath = base_url().'uploads/images/logo3.png';
	$companynamef = 'Prudent Controls Private Limited';
	$objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Image');
    $objDrawing->setDescription('Image');
    // $objDrawing->setPath($imagePath);
    $objDrawing->setCoordinates('J2');
    $objDrawing->setWidth(80);
    $objDrawing->setHeight(70);
    $sheet = $CI->excel->getActiveSheet();
    $objDrawing->setWorksheet($sheet);
    }
    
	$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setName('Bookman Old Style');
    $CI->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
	$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
	$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
	$CI->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->mergeCells('A2:L5') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A2:L5')->applyFromArray($allbordersthk);	
	$CI->excel->getActiveSheet()->getStyle('A2:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	//$CI->excel->getActiveSheet()->setTitle('TAX INVOICE');
    
    $CI->excel->getActiveSheet()->getStyle("A6:L6")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A6:L6') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	if($type == 'tax'){
    $CI->excel->getActiveSheet()->setCellValue('A6', 'TAX INVOICE');
	}else{
    $CI->excel->getActiveSheet()->setCellValue('A6', 'PROFORMA INVOICE');
	}
	$CI->excel->getActiveSheet()->getStyle('A6')->getFont()->setSize(16);
	$CI->excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
	$CI->excel->getActiveSheet()->getStyle('A6:L6')->applyFromArray($allbordersthk);	
	
	$billing_address =  (isset($tax_invc_data->billing_address) && !empty($tax_invc_data->billing_address))?$tax_invc_data->billing_address:'';
	$site_address =  (isset($tax_invc_data->site_address) && !empty($tax_invc_data->site_address))?$tax_invc_data->site_address:'';
	$customer_name =  (isset($tax_invc_data->customer_name) && !empty($tax_invc_data->customer_name))?$tax_invc_data->customer_name:'';
	$gst_no =  (isset($tax_invc_data->gst_no) && !empty($tax_invc_data->gst_no))?$tax_invc_data->gst_no:'';
	if(!empty($billing_address)){
	$billing_address = $billing_address;    
	}else{
	$billing_address=$site_address;
	}
	
	$CI->excel->getActiveSheet()->getStyle("A7:F13")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A7:F13') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A7:F13')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A7:F13')->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A7:F13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$textWithNewLine = "Billing Address:\r\n".$customer_name."\r\n".$billing_address."\r\n".'GST No.: '.$gst_no;
	$CI->excel->getActiveSheet()->setCellValue('A7',$textWithNewLine);
	$CI->excel->getActiveSheet()->getStyle("A7")->getAlignment()->setWrapText(true);
	
	
	
	
	$CI->excel->getActiveSheet()->getStyle("G7:L7")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G7:L7') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G7:L7')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('G7:L7')->applyFromArray($bottomBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G7', $companyname);
	
	if($type == 'tax'){
	$tax_invc_date =  (isset($tax_invc_data->tax_invc_date) && !empty($tax_invc_data->tax_invc_date))?date('d-m-Y',strtotime($tax_invc_data->tax_invc_date)):'';
	}else{
	$tax_invc_date =  (isset($tax_invc_data->invoice_date) && !empty($tax_invc_data->invoice_date))?date('d-m-Y',strtotime($tax_invc_data->invoice_date)):'';
	}
	$CI->excel->getActiveSheet()->getStyle("G8:L8")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G8:L8') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G8:L8')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G8', 'Date: '.$tax_invc_date);
	
	if($type == 'tax'){
	    $tax_invc_no =  (isset($tax_invc_data->tax_invc_no) && !empty($tax_invc_data->tax_invc_no))?$tax_invc_data->tax_invc_no:'';
	}else{
	    $tax_invc_no =  (isset($tax_invc_data->proforma_no) && !empty($tax_invc_data->proforma_no))?$tax_invc_data->proforma_no:'';
	}
	
	$CI->excel->getActiveSheet()->getStyle("G9:L9")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G9:L9') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G9:L9')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G9', 'Invoice No: '.$tax_invc_no);
	
	$CI->excel->getActiveSheet()->getStyle("G10:L10")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G10:L10') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G10:L10')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G10', 'PAN: '.$pannoc);
	
	$CI->excel->getActiveSheet()->getStyle("G11:L11")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G11:L11') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G11:L11')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G11', 'GST No: '.$gstnoc);
	
	$bp_code =  (isset($tax_invc_data->bp_code) && !empty($tax_invc_data->bp_code))?$tax_invc_data->bp_code:'';
	$CI->excel->getActiveSheet()->getStyle("G12:L12")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G12:L12') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G12:L12')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G12', 'Work Code: '.$bp_code);
	
	$CI->excel->getActiveSheet()->getStyle("G13:L13")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G13:L13') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G13:L13')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G13', '');
	
	$name_of_work =  (isset($tax_invc_data->name_of_work) && !empty($tax_invc_data->name_of_work))?$tax_invc_data->name_of_work:'';
	$CI->excel->getActiveSheet()->getStyle("A14:L17")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A14:L17') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A14:L17')->applyFromArray($allbordersthk);
	$CI->excel->getActiveSheet()->setCellValue('A14', 'Name of Work: '.$name_of_work);
	$CI->excel->getActiveSheet()->getStyle('A14:L17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$CI->excel->getActiveSheet()->getStyle("A18:L18")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A18:L18') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->setCellValue('A18', '');
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$CI->excel->getActiveSheet()->setCellValue('A19', 'Sr.no.');
	$CI->excel->getActiveSheet()->getStyle('A19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A19')->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getStyle("B19:G19")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('B19:G19') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('B19', 'Particulars');
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('H19', 'Qty');
	$CI->excel->getActiveSheet()->getStyle('H19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('H19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('H19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('H19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('I19', 'Unit');
	$CI->excel->getActiveSheet()->getStyle('I19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('I19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('J19', 'Rate');
	$CI->excel->getActiveSheet()->getStyle('J19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('K19', 'HSN/SAC');
	$CI->excel->getActiveSheet()->getStyle('K19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('K19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('L19', 'Amount');
	$CI->excel->getActiveSheet()->getStyle('L19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('L19')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('L19')->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('L19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	$CI->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$CI->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	$CI->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
	$total_amount = 0;
	$final_gst_amount = 0;
	$final_cgst_amount = 0;
	$final_sgst_amount = 0;
	if(isset($tax_invc_items_data) && !empty($tax_invc_items_data)){
	    $i=20;
	    $srno=1;
	    foreach($tax_invc_items_data as $key){
	        $item_description =  (isset($key->item_description) && !empty($key->item_description))?$key->item_description:'';
	        $unit =  (isset($key->unit) && !empty($key->unit))?$key->unit:'';
	        $qty =  (isset($key->qty) && !empty($key->qty))?$key->qty:'0';
	        $rate =  (isset($key->rate) && !empty($key->rate))?$key->rate:'0.00';
	        $hsn_sac_code =  (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code))?$key->hsn_sac_code:'';
	        $amount =  (isset($qty) && !empty($qty) && $qty > 0 && isset($rate) && !empty($rate) && $rate > 0)?$qty * $rate:'0';
	        $total_amount +=$amount; 
	        
	        $gst_type =  (isset($key->gst_type) && !empty($key->gst_type) && $key->gst_type == 'intra-state')?'intra-state':'inter-state';
	        if($gst_type == 'intra-state'){
	        $gst_amount =  0;
	        $cgst_amount =  (isset($key->cgst_amount) && !empty($key->cgst_amount))?$key->cgst_amount:'0.00';
	        $sgst_amount =  (isset($key->sgst_amount) && !empty($key->sgst_amount))?$key->sgst_amount:'0.00';
	        }else{
	        $gst_amount =  (isset($key->gst_amount) && !empty($key->gst_amount))?$key->gst_amount:'0.00';
	        $cgst_amount =  0;
	        $sgst_amount =  0;
	        }
	        $final_gst_amount +=$gst_amount;
	        $final_cgst_amount +=$cgst_amount;
	        $final_sgst_amount +=$sgst_amount;

			$estimatedCharactersPerRow = 50; // Adjust this value based on your needs
			$requiredRowHeight = ceil(strlen($item_description) / $estimatedCharactersPerRow);
	        $CI->excel->getActiveSheet()->getRowDimension($i)->setRowHeight($requiredRowHeight * 15);

	        $CI->excel->getActiveSheet()->setCellValue('A'.$i, $srno);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($allborders);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($leftBorderStylethk);
			$CI->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        	$CI->excel->getActiveSheet()->getStyle("B".$i.":G".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('B'.$i.':G'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->applyFromArray($allborders);
        	$CI->excel->getActiveSheet()->setCellValue('B'.$i, $item_description);
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        	
        	$CI->excel->getActiveSheet()->setCellValue('H'.$i, $unit);
        	$CI->excel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($allborders);
			$CI->excel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        	$CI->excel->getActiveSheet()->setCellValue('I'.$i, $qty);
        	$CI->excel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($allborders);
			$CI->excel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


        	$CI->excel->getActiveSheet()->setCellValue('J'.$i, $rate);
        	$CI->excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($allborders);
			$CI->excel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        	$CI->excel->getActiveSheet()->setCellValue('K'.$i, $hsn_sac_code);
        	$CI->excel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($allborders);
			$CI->excel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        	$CI->excel->getActiveSheet()->setCellValue('L'.$i, $amount);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($rightBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($leftBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($bottomBorderStyle);
			$CI->excel->getActiveSheet()->getStyle('L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $i++;
            $srno++;
	    }    
	}else{
	    $CI->excel->getActiveSheet()->setCellValue('A20', 'Sr.no.');
        $CI->excel->getActiveSheet()->getStyle('A20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->getStyle('A20')->applyFromArray($leftBorderStylethk);
        	
        $CI->excel->getActiveSheet()->getStyle("B20:G20")->getAlignment()->setWrapText(true);
        $CI->excel->getActiveSheet()->mergeCells('B20:G20') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        $CI->excel->getActiveSheet()->getStyle('B20:G20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('B20', '');
        $CI->excel->getActiveSheet()->getStyle('B20:G20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	
        $CI->excel->getActiveSheet()->setCellValue('H20', '');
        $CI->excel->getActiveSheet()->getStyle('H20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('I20', '');
        $CI->excel->getActiveSheet()->getStyle('I20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('J20', '');
        $CI->excel->getActiveSheet()->getStyle('J20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('K20', '');
        $CI->excel->getActiveSheet()->getStyle('K20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('L20', '');
        $CI->excel->getActiveSheet()->getStyle('L20')->applyFromArray($rightBorderStylethk);
        $CI->excel->getActiveSheet()->getStyle('L20')->applyFromArray($leftBorderStylethk);
        $CI->excel->getActiveSheet()->getStyle('L20')->applyFromArray($topBorderStyle);
        $CI->excel->getActiveSheet()->getStyle('L20')->applyFromArray($bottomBorderStyle);
    }
    if(isset($tax_invc_items_data) && !empty($tax_invc_items_data)){ $count = count($tax_invc_items_data) + 20;}else{ $count = 20;}
	for($j=$count;$j<($count+6);$j++){
	    $CI->excel->getActiveSheet()->setCellValue('A'.$j, '');
        $CI->excel->getActiveSheet()->getStyle('A'.$j)->applyFromArray($leftBorderStylethk);
	
    	$CI->excel->getActiveSheet()->getStyle("B".$j.":G".$j)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('B'.$j.':G'.$j) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->setCellValue('B'.$j, '');
    	$CI->excel->getActiveSheet()->getStyle('B'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->setCellValue('H'.$j, '');
    	$CI->excel->getActiveSheet()->setCellValue('I'.$j, '');
    	$CI->excel->getActiveSheet()->setCellValue('J'.$j, '');
    	if($j == $i+1){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'Basic Amount');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+2 && $final_gst_amount == 0){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'CGST');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+3 && $final_gst_amount == 0){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'SGST');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+2 && $final_gst_amount > 0){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'IGST');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+3 && $final_gst_amount > 0){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, '');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+5){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'Total amount of this invoice');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }else{
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, '');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }
	    $final_amount = 0;
	    if($final_gst_amount  > 0){
	    $final_amount =  $total_amount +  $final_gst_amount;  
	    }elseif($final_cgst_amount  > 0 && $final_sgst_amount  > 0){
	    $final_amount =  $total_amount +  $final_sgst_amount + $final_cgst_amount;  
	    }else{
	    $final_amount =  $total_amount ;  
	    }
	    if($j == $i+1){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $total_amount);
    	}elseif($j == $i+2 && $final_gst_amount == 0){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $final_cgst_amount);
    	}elseif($j == $i+3 && $final_gst_amount == 0){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $final_sgst_amount);
    	}elseif($j == $i+2 && $final_gst_amount > 0){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $final_gst_amount);
    	}elseif($j == $i+3 && $final_gst_amount > 0){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, '');
    	}elseif($j == $i+5){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $final_amount);
    	}else{
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, '');
    	}
    	
    	$CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($topBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($rightBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($leftBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($bottomBorderStyle);
    }
    for($k=($count+6);$k<($count+9);$k++){
        if($k == ($count+6)){
        $CI->excel->getActiveSheet()->getStyle("A".$k.":L".$k)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('A'.$k.':L'.$k) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($topBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($rightBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($leftBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($bottomBorderStyle);
    	$CI->excel->getActiveSheet()->setCellValue('A'.$k, '');
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        }elseif($k == ($count+6)+1){
        $CI->excel->getActiveSheet()->getStyle("A".$k.":L".$k)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('A'.$k.':L'.$k) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->setCellValue('A'.$k, '');
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($leftBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($rightBorderStylethk);
        }
	}
	$lm = $count+8;
	$CI->excel->getActiveSheet()->getStyle("A".$lm.":I".$lm)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm.':I'.$lm) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm.':I'.$lm)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm.':I'.$lm)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm, 'BANK DETAILS:');
    
    $CI->excel->getActiveSheet()->getStyle("J".$lm.":L".$lm)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J'.$lm.':L'.$lm) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('J'.$lm, '');
	$CI->excel->getActiveSheet()->getStyle('J'.$lm)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm.':L'.$lm)->applyFromArray($rightBorderStylethk);
		    
	$lm1 = $count+9;
	$CI->excel->getActiveSheet()->getStyle("A".$lm1.":I".$lm1)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm1.':I'.$lm1) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm1.':I'.$lm1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm1.':I'.$lm1)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm1, 'Bank Name: '.$bank_name);
    
    $lm2 = $count+10;
	$CI->excel->getActiveSheet()->getStyle("A".$lm2.":I".$lm2)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm2.':I'.$lm2) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm2.':I'.$lm2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm2.':I'.$lm2)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm2, 'Account No: '.$bank_acc);
    
    $lm3 = $count+11;
	$CI->excel->getActiveSheet()->getStyle("A".$lm3.":I".$lm3)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm3.':I'.$lm3) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm3.':I'.$lm3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm3.':I'.$lm3)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm3, 'IFSC Code: '.$ifsccode);
    
    $lm4 = $count+12;
	$CI->excel->getActiveSheet()->getStyle("A".$lm4.":I".$lm4)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm4.':I'.$lm4) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm4.':I'.$lm4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm4.':I'.$lm4)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm4, 'Branch Address: '.$branch_addr);
    
    $lm5 = $count+13;
	$CI->excel->getActiveSheet()->getStyle("A".$lm5.":I".$lm5)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm5.':I'.$lm5) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm5.':I'.$lm5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm5.':I'.$lm5)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm5, '');
    
    
	$CI->excel->getActiveSheet()->getStyle("J".$lm1.":L".$lm1)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J'.$lm1.':L'.$lm1) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('J'.$lm1, 'For '.$companynamef);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$lm6 = $lm1 + 3;
	$CI->excel->getActiveSheet()->getStyle("J".$lm1.":L".$lm6)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J'.$lm1.':L'.$lm6) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->applyFromArray($bottomBorderStyle);
	
    $lm7 = $lm6 + 1;
	$CI->excel->getActiveSheet()->getStyle("J".$lm7.":L".$lm7)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J'.$lm7.':L'.$lm7) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('J'.$lm7, 'Authorised Signatory');
	$CI->excel->getActiveSheet()->getStyle('J'.$lm7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm7.':L'.$lm7)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm7.':L'.$lm7)->applyFromArray($rightBorderStylethk);
	
	$lm8 = $lm7 + 1;
	$CI->excel->getActiveSheet()->getStyle("A".$lm8.":L".$lm8)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.$lm8.':L'.$lm8) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.$lm8.':L'.$lm8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm8.':L'.$lm8)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm8.':L'.$lm8)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm8.':L'.$lm8)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('A'.$lm8, $faddr);
	
	$lm9 = $lm8 + 1;
	$CI->excel->getActiveSheet()->getStyle("A".$lm9.":L".$lm9)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.$lm9.':L'.$lm9) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.$lm9.':L'.$lm9)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm9.':L'.$lm9)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm9.':L'.$lm9)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('A'.$lm9, $fdets);
	
	$lm10 = $lm9 + 1;
	$CI->excel->getActiveSheet()->getStyle("A".$lm10.":L".$lm10)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.$lm10.':L'.$lm10) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.$lm10.':L'.$lm10)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm10.':L'.$lm10)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm10.':L'.$lm10)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm10.':L'.$lm10)->applyFromArray($bottomBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('A'.$lm10, $fweb);
	
	if($type == 'tax'){
	$tax_invc_no =  (isset($tax_invc_data->tax_invc_no) && !empty($tax_invc_data->tax_invc_no))?$tax_invc_data->tax_invc_no:'0';
	$filename=$tax_invc_no."_TAX_INVOICE_FORMAR_2.xls";
	}else{
	$tax_invc_no =  (isset($tax_invc_data->proforma_no) && !empty($tax_invc_data->proforma_no))?$tax_invc_data->proforma_no:'0';
	$filename=$tax_invc_no."_PROFORMA_INVOICE_FORMAR_2.xls";
	}
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename='.$filename); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	header('Cache-Control: max-age=1');
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header ('Cache-Control: cache, must-revalidate');
	header ('Pragma: public');
	$objWriter = PHPExcel_IOFactory::createWriter($CI->excel, 'Excel5');
	$objWriter->save('php://output'); 
    }
public function invoice_format_1($tax_invc_data,$tax_invc_items_data,$tax_invc_items_hsn_data,$type){
   
    if($type == 'tax'){
    $excelname='TAX INVOICE FORMAT 2';
    }else{
    $excelname='PROFORMA INVOICE FORMAT 2';
    }
    $CI =& get_instance(); 
    $CI->load->model('common_model');
    $CI->load->library('excel');
    PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder());
    $CI->excel->getProperties()->setCreator("prudent")->setLastModifiedBy("prudent")->setTitle($excelname)
    ->setSubject($excelname)->setDescription("System Generated File.")->setKeywords("office 2007")->setCategory("Confidential");
    $allborders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $allbordersthk = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $rightBorderStyle = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $rightBorderStylethk = array('borders' => array('right' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $leftBorderStylethk = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    $leftBorderStyle = array('borders' => array('left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    
    $topBorderStyle = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $topBorderStylethk = array('borders' => array('top' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $bottomBorderStyle = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );
    $bottomBorderStylethk = array('borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THICK, ), ), );
    
    $CI->excel->setActiveSheetIndex(0);
	$CI->excel->getActiveSheet()->getStyle("A1:L5")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A1:L1') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($allborders);
	$CI->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$bank_name = 'Janakalyan Sahakari Bank Ltd.';
	$ifsccode = 'JSBL0000018';
	$branch_addr = 'Sindhi Society';
	$companyname='';
	$companynamef=$gstnoc=$pannoc=$faddr=$fdets=$fweb='';
	$work_order_on =  (isset($tax_invc_data->work_order_on) && !empty($tax_invc_data->work_order_on) && $tax_invc_data->work_order_on == 'Prudent EPC')?'Prudent EPC':'Prudent Controls';
	if($work_order_on == 'Prudent EPC'){
	$faddr = 'Registered office: 91/B, Kamgar Nagar, Vishal Tower No.2, S.G.Barve Marg, Kurla, Mumbai 400024';
	$fdets = 'CIN : U72900MH2019PTC323399, Land Line: +91 022-25220676';
	$fweb = 'www.prudentepc.com, sales@prudentepc.com';
	$gstnoc='27AAKCP4656L1ZS';
	$pannoc='AAKCP4656L';
	$bank_acc = '018013500000016';
	$companynamef = 'Prudent EPC Private Limited';
	$companyname = 'PRUDENT EPC PRIVATE LIMITED';
// 	$imagePath = '/home3/trackmrg/public_html/prudent/uploads/images/logo2.png';
	$imagePath = base_url().'uploads/images/logo2.png';
	$objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Image');
    $objDrawing->setDescription('Image');
    // $objDrawing->setPath($imagePath);
    $objDrawing->setCoordinates('J2');
    $objDrawing->setWidth(180);
    $objDrawing->setHeight(90);
    $sheet = $CI->excel->getActiveSheet();
    $objDrawing->setWorksheet($sheet);
    }else{
	$faddr = 'Registered Office – 91/B, S G Barve Marg, Kamgar Nagar, Kurla (East), Mumbai-400024';
	$fdets = 'CIN: U72300MH2012PTC229314, Land Line: 022 25220676, 8879650193,';
	$fweb = 'www.prudentcontrols.com';
	$gstnoc='27AAGCP5489F1ZO';
	$pannoc='AAGCP5489F';
	$bank_acc = '018011300001395';
	$companynamef = 'Prudent Controls Private Limited';
	$companyname = 'PRUDENT CONTROLS PRIVATE LIMITED';
// 	$imagePath = '/home3/trackmrg/public_html/prudent/uploads/images/logo3.png';
	$imagePath = base_url().'uploads/images/logo3.png';
	$objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Image');
    $objDrawing->setDescription('Image');
    // $objDrawing->setPath($imagePath);
    $objDrawing->setCoordinates('J2');
    $objDrawing->setWidth(80);
    $objDrawing->setHeight(70);
    $sheet = $CI->excel->getActiveSheet();
    $objDrawing->setWorksheet($sheet);
    }
    
	$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setName('Bookman Old Style');
    $CI->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
	$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
	$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
	$CI->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->mergeCells('A2:L5') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A2:L5')->applyFromArray($allbordersthk);	
	$CI->excel->getActiveSheet()->getStyle('A2:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	//$CI->excel->getActiveSheet()->setTitle('TAX INVOICE');
    
    $CI->excel->getActiveSheet()->getStyle("A6:L6")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A6:L6') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	if($type == 'tax'){
    $CI->excel->getActiveSheet()->setCellValue('A6', 'TAX INVOICE');
	}else{
    $CI->excel->getActiveSheet()->setCellValue('A6', 'PROFORMA INVOICE');
	}
	$CI->excel->getActiveSheet()->getStyle('A6')->getFont()->setSize(16);
	$CI->excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(true);
	$CI->excel->getActiveSheet()->getStyle('A6:L6')->applyFromArray($allbordersthk);	
	
	$billing_address =  (isset($tax_invc_data->billing_address) && !empty($tax_invc_data->billing_address))?$tax_invc_data->billing_address:'';
	$site_address =  (isset($tax_invc_data->site_address) && !empty($tax_invc_data->site_address))?$tax_invc_data->site_address:'';
	$customer_name =  (isset($tax_invc_data->customer_name) && !empty($tax_invc_data->customer_name))?$tax_invc_data->customer_name:'';
	$gst_no =  (isset($tax_invc_data->gst_no) && !empty($tax_invc_data->gst_no))?$tax_invc_data->gst_no:'';
	if(!empty($billing_address)){
	$billing_address = $billing_address;    
	}else{
	$billing_address=$site_address;
	}
	$CI->excel->getActiveSheet()->getStyle("A7:F13")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A7:F13') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A7:F13')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A7:F13')->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A7:F13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$textWithNewLine = "Billing Address:\r\n".$customer_name."\r\n".$billing_address."\r\n".' GST NO.: '.$gst_no;
	$CI->excel->getActiveSheet()->setCellValue('A7',$textWithNewLine);
	$CI->excel->getActiveSheet()->getStyle("A7")->getAlignment()->setWrapText(true);
	
	
	
	
	$CI->excel->getActiveSheet()->getStyle("G7:L7")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G7:L7') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G7:L7')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('G7:L7')->applyFromArray($bottomBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G7', $companyname);
	
	if($type == 'tax'){
	$tax_invc_date =  (isset($tax_invc_data->tax_invc_date) && !empty($tax_invc_data->tax_invc_date))?date('d-m-Y',strtotime($tax_invc_data->tax_invc_date)):'';
	}else{
	$tax_invc_date =  (isset($tax_invc_data->invoice_date) && !empty($tax_invc_data->invoice_date))?date('d-m-Y',strtotime($tax_invc_data->invoice_date)):'';
	}
	$CI->excel->getActiveSheet()->getStyle("G8:L8")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G8:L8') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G8:L8')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G8', 'Date: '.$tax_invc_date);
	
	if($type == 'tax'){
	    $tax_invc_no =  (isset($tax_invc_data->tax_invc_no) && !empty($tax_invc_data->tax_invc_no))?$tax_invc_data->tax_invc_no:'';
	}else{
	    $tax_invc_no =  (isset($tax_invc_data->proforma_no) && !empty($tax_invc_data->proforma_no))?$tax_invc_data->proforma_no:'';
	}
	
	$CI->excel->getActiveSheet()->getStyle("G9:L9")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G9:L9') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G9:L9')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G9', 'Invoice No: '.$tax_invc_no);
	
	$CI->excel->getActiveSheet()->getStyle("G10:L10")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G10:L10') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G10:L10')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G10', 'PAN: '.$pannoc);
	
	$CI->excel->getActiveSheet()->getStyle("G11:L11")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G11:L11') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G11:L11')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G11', 'GST No: '.$gstnoc);
	
	$bp_code =  (isset($tax_invc_data->bp_code) && !empty($tax_invc_data->bp_code))?$tax_invc_data->bp_code:'';
	$CI->excel->getActiveSheet()->getStyle("G12:L12")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G12:L12') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G12:L12')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G12', 'Agreement No: '.$bp_code);
	
	$CI->excel->getActiveSheet()->getStyle("G13:L13")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G13:L13') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G13:L13')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('G13', '');
	
	$billing_address =  (isset($tax_invc_data->billing_address) && !empty($tax_invc_data->billing_address))?$tax_invc_data->billing_address:'';
	$site_address =  (isset($tax_invc_data->site_address) && !empty($tax_invc_data->site_address))?$tax_invc_data->site_address:'';
	$customer_name =  (isset($tax_invc_data->customer_name) && !empty($tax_invc_data->customer_name))?$tax_invc_data->customer_name:'';
	if(!empty($billing_address)){
	$billing_address = $billing_address;    
	}else{
	$billing_address=$site_address;
	}
	$CI->excel->getActiveSheet()->getStyle("A14:L18")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A14:L18') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A14:L18')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A14:L18')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A14:L18')->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A14:L18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$textWithNewLine = "Shipping Address:\r\n".$customer_name."\r\n".$billing_address;
	$CI->excel->getActiveSheet()->setCellValue('A14',$textWithNewLine);
	$CI->excel->getActiveSheet()->getStyle("A14")->getAlignment()->setWrapText(true);
	
	/*$name_of_work =  (isset($tax_invc_data->name_of_work) && !empty($tax_invc_data->name_of_work))?$tax_invc_data->name_of_work:'';
	$CI->excel->getActiveSheet()->getStyle("G14:L17")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('G14:L17') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('G14:L17')->applyFromArray($allbordersthk);
	$CI->excel->getActiveSheet()->setCellValue('G14', 'Name of Work: '.$name_of_work);
	$CI->excel->getActiveSheet()->getStyle('G14:L17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$CI->excel->getActiveSheet()->getStyle("A18:L18")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A18:L18') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->setCellValue('A18', '');
	$CI->excel->getActiveSheet()->getStyle('A18:L18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	*/
	$CI->excel->getActiveSheet()->setCellValue('A19', 'Sr.no.');
	$CI->excel->getActiveSheet()->getStyle('A19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A19')->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getStyle("B19:G19")->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('B19:G19') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('B19', 'Particulars');
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('B19:G19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('H19', 'HSN Code');
	$CI->excel->getActiveSheet()->getStyle('H19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('H19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('H19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('H19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('I19', 'Qty');
	$CI->excel->getActiveSheet()->getStyle('I19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('I19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('I19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('J19', 'UOM');
	$CI->excel->getActiveSheet()->getStyle('J19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('K19', 'Rate');
	$CI->excel->getActiveSheet()->getStyle('K19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('K19')->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K19')->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('K19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('L19', 'Amount');
	$CI->excel->getActiveSheet()->getStyle('L19')->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('L19')->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('L19')->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('L19')->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	$CI->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$CI->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	$CI->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
	$total_amount = 0;
	$final_gst_amount = 0;
	$final_cgst_amount = 0;
	$final_sgst_amount = 0;
	if(isset($tax_invc_items_data) && !empty($tax_invc_items_data)){
	    $i=20;
	    $srno=1;
	    foreach($tax_invc_items_data as $key){
	        $item_description =  (isset($key->item_description) && !empty($key->item_description))?$key->item_description:'';
	        $unit =  (isset($key->unit) && !empty($key->unit))?$key->unit:'';
	        $qty =  (isset($key->qty) && !empty($key->qty))?$key->qty:'0';
	        $rate =  (isset($key->rate) && !empty($key->rate))?$key->rate:'0.00';
	        $hsn_sac_code =  (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code))?$key->hsn_sac_code:'';
	        $amount =  (isset($qty) && !empty($qty) && $qty > 0 && isset($rate) && !empty($rate) && $rate > 0)?$qty * $rate:'0';
	        $total_amount +=$amount; 
	        
	        $gst_type =  (isset($key->gst_type) && !empty($key->gst_type) && $key->gst_type == 'intra-state')?'intra-state':'inter-state';
	        if($gst_type == 'intra-state'){
	        $gst_amount =  0;
	        $cgst_amount =  (isset($key->cgst_amount) && !empty($key->cgst_amount))?$key->cgst_amount:'0.00';
	        $sgst_amount =  (isset($key->sgst_amount) && !empty($key->sgst_amount))?$key->sgst_amount:'0.00';
	        }else{
	        $gst_amount =  (isset($key->gst_amount) && !empty($key->gst_amount))?$key->gst_amount:'0.00';
	        $cgst_amount =  0;
	        $sgst_amount =  0;
	        }
	        $final_gst_amount +=$gst_amount;
	        $final_cgst_amount +=$cgst_amount;
	        $final_sgst_amount +=$sgst_amount;

			$estimatedCharactersPerRow = 50; // Adjust this value based on your needs
			$requiredRowHeight = ceil(strlen($item_description) / $estimatedCharactersPerRow);
	        $CI->excel->getActiveSheet()->getRowDimension($i)->setRowHeight($requiredRowHeight * 15);
	        
	        $CI->excel->getActiveSheet()->setCellValue('A'.$i, $srno);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($allborders);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($leftBorderStylethk);
			$CI->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        	
        	$CI->excel->getActiveSheet()->getStyle("B".$i.":G".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('B'.$i.':G'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->applyFromArray($allborders);
        	$CI->excel->getActiveSheet()->setCellValue('B'.$i, $item_description);
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        	
        	$CI->excel->getActiveSheet()->setCellValue('H'.$i, $hsn_sac_code);
        	$CI->excel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($allborders);
			$CI->excel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        	$CI->excel->getActiveSheet()->setCellValue('I'.$i, $qty);
        	$CI->excel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($allborders);
			$CI->excel->getActiveSheet()->getStyle('I'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        	$CI->excel->getActiveSheet()->setCellValue('J'.$i, $unit);
        	$CI->excel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($allborders);
			$CI->excel->getActiveSheet()->getStyle('J'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        	$CI->excel->getActiveSheet()->setCellValue('K'.$i, $rate);
        	$CI->excel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($allborders);
			$CI->excel->getActiveSheet()->getStyle('K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        	$CI->excel->getActiveSheet()->setCellValue('L'.$i, $amount);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($rightBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($leftBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($bottomBorderStyle);
			$CI->excel->getActiveSheet()->getStyle('L'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $i++;
            $srno++;
	    }    
	}else{
	    $CI->excel->getActiveSheet()->setCellValue('A20', 'Sr.no.');
        $CI->excel->getActiveSheet()->getStyle('A20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->getStyle('A20')->applyFromArray($leftBorderStylethk);
        	
        $CI->excel->getActiveSheet()->getStyle("B20:G20")->getAlignment()->setWrapText(true);
        $CI->excel->getActiveSheet()->mergeCells('B20:G20') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        $CI->excel->getActiveSheet()->getStyle('B20:G20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('B20', '');
        $CI->excel->getActiveSheet()->getStyle('B20:G20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	
        $CI->excel->getActiveSheet()->setCellValue('H20', '');
        $CI->excel->getActiveSheet()->getStyle('H20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('I20', '');
        $CI->excel->getActiveSheet()->getStyle('I20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('J20', '');
        $CI->excel->getActiveSheet()->getStyle('J20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('K20', '');
        $CI->excel->getActiveSheet()->getStyle('K20')->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('L20', '');
        $CI->excel->getActiveSheet()->getStyle('L20')->applyFromArray($rightBorderStylethk);
        $CI->excel->getActiveSheet()->getStyle('L20')->applyFromArray($leftBorderStylethk);
        $CI->excel->getActiveSheet()->getStyle('L20')->applyFromArray($topBorderStyle);
        $CI->excel->getActiveSheet()->getStyle('L20')->applyFromArray($bottomBorderStyle);
    }
    if(isset($tax_invc_items_data) && !empty($tax_invc_items_data)){ $count = count($tax_invc_items_data) + 20;}else{ $count = 20;}
    for($j=$count;$j<($count+6);$j++){
	    $CI->excel->getActiveSheet()->setCellValue('A'.$j, '');
        $CI->excel->getActiveSheet()->getStyle('A'.$j)->applyFromArray($leftBorderStylethk);
	
    	$CI->excel->getActiveSheet()->getStyle("B".$j.":G".$j)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('B'.$j.':G'.$j) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->setCellValue('B'.$j, '');
    	$CI->excel->getActiveSheet()->getStyle('B'.$j.':G'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->setCellValue('H'.$j, '');
    	$CI->excel->getActiveSheet()->setCellValue('I'.$j, '');
    	$CI->excel->getActiveSheet()->setCellValue('J'.$j, '');
    	if($j == $i+1){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'Basic Amount');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+2 && $final_gst_amount == 0){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'CGST');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+3 && $final_gst_amount == 0){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'SGST');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+2 && $final_gst_amount > 0){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'IGST');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+3 && $final_gst_amount > 0){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, '');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }elseif($j == $i+5){
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, 'Total amount of this invoice');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }else{
    	$CI->excel->getActiveSheet()->setCellValue('K'.$j, '');
    	$CI->excel->getActiveSheet()->getStyle('K'.$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	    }
	    $final_amount = 0;
	    if($final_gst_amount  > 0){
	    $final_amount =  $total_amount +  $final_gst_amount;  
	    }elseif($final_cgst_amount  > 0 && $final_sgst_amount  > 0){
	    $final_amount =  $total_amount +  $final_sgst_amount + $final_cgst_amount;  
	    }else{
	    $final_amount =  $total_amount ;  
	    }
	    if($j == $i+1){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $total_amount);
    	}elseif($j == $i+2 && $final_gst_amount == 0){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $final_cgst_amount);
    	}elseif($j == $i+3 && $final_gst_amount == 0){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $final_sgst_amount);
    	}elseif($j == $i+2 && $final_gst_amount > 0){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $final_gst_amount);
    	}elseif($j == $i+3 && $final_gst_amount > 0){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, '');
    	}elseif($j == $i+5){
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, $final_amount);
    	}else{
    	$CI->excel->getActiveSheet()->setCellValue('L'.$j, '');
    	}
    	
    	$CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($topBorderStyle);
    	$CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($rightBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($leftBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($bottomBorderStyle);
    }
    $rw=$count+6;
    $CI->excel->getActiveSheet()->getStyle("A".$rw.":L".$rw)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.$rw.':L'.$rw) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->applyFromArray($topBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->applyFromArray($bottomBorderStyle);
	$CI->excel->getActiveSheet()->setCellValue('A'.$rw, '');
	$CI->excel->getActiveSheet()->getStyle('A'.$rw.':L'.$rw)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$rw1=$count + 7;
    $CI->excel->getActiveSheet()->setCellValue('A'.$rw1, 'Sr.no.');
	$CI->excel->getActiveSheet()->getStyle('A'.$rw1)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$rw1)->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('A'.$rw1)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$rw1)->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getStyle("B".$rw1.":G".$rw1)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('B'.$rw1.':G'.$rw1) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('B'.$rw1, 'HSN Code');
	$CI->excel->getActiveSheet()->getStyle('B'.$rw1.':G'.$rw1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('B'.$rw1.':G'.$rw1)->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('B'.$rw1.':G'.$rw1)->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('B'.$rw1.':G'.$rw1)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('B'.$rw1.':G'.$rw1)->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getStyle("H".$rw1.":I".$rw1)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('H'.$rw1.':I'.$rw1) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('H'.$rw1, 'Amount');
	$CI->excel->getActiveSheet()->getStyle('H'.$rw1.':I'.$rw1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('H'.$rw1.':I'.$rw1)->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('H'.$rw1.':I'.$rw1)->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('H'.$rw1.':I'.$rw1)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('H'.$rw1.':I'.$rw1)->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getStyle("J".$rw1.":K".$rw1)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J'.$rw1.':K'.$rw1) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('J'.$rw1, 'Rate');
	$CI->excel->getActiveSheet()->getStyle('J'.$rw1.':K'.$rw1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('J'.$rw1.':K'.$rw1)->applyFromArray($rightBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J'.$rw1.':K'.$rw1)->applyFromArray($leftBorderStyle);
	$CI->excel->getActiveSheet()->getStyle('J'.$rw1.':K'.$rw1)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J'.$rw1.':K'.$rw1)->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->setCellValue('L'.$rw1, 'Amount');
	$CI->excel->getActiveSheet()->getStyle('L'.$rw1)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('L'.$rw1)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('L'.$rw1)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('L'.$rw1)->applyFromArray($bottomBorderStyle);
	
	$CI->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
	$CI->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	$CI->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
	$CI->excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
	$CI->excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
	
	$rw2=$count+8;
	$total_hsn_amount = 0;
	if(isset($tax_invc_items_hsn_data) && !empty($tax_invc_items_hsn_data)){
	    $i=$count+8;
	    $looprow = count($tax_invc_items_hsn_data);
	    $srno=1;
	    for($tx=0;$tx<$looprow;$tx++){
	        if($tx%2 == 0) {
	        $qty =  (isset($tax_invc_items_hsn_data[$tx]['qty']) && !empty($tax_invc_items_hsn_data[$tx]['qty']))?$tax_invc_items_hsn_data[$tx]['qty']:'0';
	        $rate =  (isset($tax_invc_items_hsn_data[$tx]['rate']) && !empty($tax_invc_items_hsn_data[$tx]['rate']))?$tax_invc_items_hsn_data[$tx]['rate']:'0.00';
	        $hsn_sac_code =  (isset($tax_invc_items_hsn_data[$tx]['hsn_sac_code']) && !empty($tax_invc_items_hsn_data[$tx]['hsn_sac_code']))?$tax_invc_items_hsn_data[$tx]['hsn_sac_code']:'';
	        $amount =  (isset($qty) && !empty($qty) && $qty > 0 && isset($rate) && !empty($rate) && $rate > 0)?$qty * $rate:'0';
	        $amount_with_gst = 0;
	        $gst_type =  (isset($tax_invc_items_hsn_data[$tx]['gst_type']) && !empty($tax_invc_items_hsn_data[$tx]['gst_type']) && $tax_invc_items_hsn_data[$tx]['gst_type'] == 'intra-state')?'intra-state':'inter-state';
	        if($gst_type == 'intra-state'){
	        $gst_rate =  0;
	        $cgst_rate =  (isset($tax_invc_items_hsn_data[$tx]['cgst']) && !empty($tax_invc_items_hsn_data[$tx]['cgst']))?$tax_invc_items_hsn_data[$tx]['cgst']:'0.00';
	        $sgst_rate =  (isset($tax_invc_items_hsn_data[$tx]['sgst']) && !empty($tax_invc_items_hsn_data[$tx]['sgst']))?$tax_invc_items_hsn_data[$tx]['sgst']:'0.00';
	        $gst_amount =  0;
	        $cgst_amount =  (isset($tax_invc_items_hsn_data[$tx]['cgst_amount']) && !empty($tax_invc_items_hsn_data[$tx]['cgst_amount']))?$tax_invc_items_hsn_data[$tx]['cgst_amount']:'0.00';
	        $sgst_amount =  (isset($tax_invc_items_hsn_data[$tx]['sgst_amount']) && !empty($tax_invc_items_hsn_data[$tx]['sgst_amount']))?$tax_invc_items_hsn_data[$tx]['sgst_amount']:'0.00';
	        $amount_with_gst = $amount + $cgst_amount + $sgst_amount;
	        }else{
	        $cgst_rate =  0;
	        $sgst_rate =  0;
	        $gst_rate =  (isset($tax_invc_items_hsn_data[$tx]['gst']) && !empty($tax_invc_items_hsn_data[$tx]['gst']))?$tax_invc_items_hsn_data[$tx]['gst']:'0.00';
	        $gst_amount =  (isset($tax_invc_items_hsn_data[$tx]['gst_amount']) && !empty($tax_invc_items_hsn_data[$tx]['gst_amount']))?$tax_invc_items_hsn_data[$tx]['gst_amount']:'0.00';
	        $cgst_amount =  0;
	        $sgst_amount =  0;
	        $amount_with_gst = $amount + $gst_amount;
	        }
	        $CI->excel->getActiveSheet()->setCellValue('A'.$i, $srno);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($leftBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($topBorderStyle);
        	
        	$CI->excel->getActiveSheet()->getStyle("B".$i.":G".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('B'.$i.':G'.$i)->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->setCellValue('B'.$i, $hsn_sac_code);
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	
        	$CI->excel->getActiveSheet()->getStyle("H".$i.":I".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('H'.$i.':I'.$i)->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->setCellValue('H'.$i, $amount);
        	$CI->excel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	
        	if($gst_type == 'intra-state'){
        	$CI->excel->getActiveSheet()->getStyle("J".$i.":K".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('J'.$i.':K'.$i)->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($allborders);
        	$CI->excel->getActiveSheet()->setCellValue('J'.$i, $cgst_rate.' (%)');
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	
        	$CI->excel->getActiveSheet()->setCellValue('L'.$i, $cgst_amount);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($rightBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($leftBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($topBorderStyle);
        	$total_hsn_amount +=$cgst_amount; 
        	}else{
        	$CI->excel->getActiveSheet()->getStyle("J".$i.":K".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('J'.$i.':K'.$i)->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($rightBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($topBorderStyle);
        	$CI->excel->getActiveSheet()->setCellValue('J'.$i, $gst_rate.' (%)');
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	
        	$CI->excel->getActiveSheet()->setCellValue('L'.$i, $gst_amount);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($rightBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($leftBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($topBorderStyle);
        	$total_hsn_amount +=$gst_amount; 
        	}
        	$srno++;
	        }else{
	        $qty =  (isset($tax_invc_items_hsn_data[$tx-1]['qty']) && !empty($tax_invc_items_hsn_data[$tx-1]['qty']))?$tax_invc_items_hsn_data[$tx-1]['qty']:'0';
	        $rate =  (isset($tax_invc_items_hsn_data[$tx-1]['rate']) && !empty($tax_invc_items_hsn_data[$tx-1]['rate']))?$tax_invc_items_hsn_data[$tx-1]['rate']:'0.00';
	        $hsn_sac_code =  (isset($tax_invc_items_hsn_data[$tx-1]['hsn_sac_code']) && !empty($tax_invc_items_hsn_data[$tx-1]['hsn_sac_code']))?$tax_invc_items_hsn_data[$tx-1]['hsn_sac_code']:'';
	        $amount =  (isset($qty) && !empty($qty) && $qty > 0 && isset($rate) && !empty($rate) && $rate > 0)?$qty * $rate:'0';
	        $amount_with_gst = 0;
	        $gst_type =  (isset($tax_invc_items_hsn_data[$tx-1]['gst_type']) && !empty($tax_invc_items_hsn_data[$tx-1]['gst_type']) && $tax_invc_items_hsn_data[$tx-1]['gst_type'] == 'intra-state')?'intra-state':'inter-state';
	        if($gst_type == 'intra-state'){
	        $gst_rate =  0;
	        $cgst_rate =  (isset($tax_invc_items_hsn_data[$tx-1]['cgst']) && !empty($tax_invc_items_hsn_data[$tx-1]['cgst']))?$tax_invc_items_hsn_data[$tx-1]['cgst']:'0.00';
	        $sgst_rate =  (isset($tax_invc_items_hsn_data[$tx-1]['sgst']) && !empty($tax_invc_items_hsn_data[$tx-1]['sgst']))?$tax_invc_items_hsn_data[$tx-1]['sgst']:'0.00';
	        $gst_amount =  0;
	        $cgst_amount =  (isset($tax_invc_items_hsn_data[$tx-1]['cgst_amount']) && !empty($tax_invc_items_hsn_data[$tx-1]['cgst_amount']))?$tax_invc_items_hsn_data[$tx-1]['cgst_amount']:'0.00';
	        $sgst_amount =  (isset($tax_invc_items_hsn_data[$tx-1]['sgst_amount']) && !empty($tax_invc_items_hsn_data[$tx-1]['sgst_amount']))?$tax_invc_items_hsn_data[$tx-1]['sgst_amount']:'0.00';
	        $amount_with_gst = $amount + $cgst_amount + $sgst_amount;
	        }else{
	        $cgst_rate =  0;
	        $sgst_rate =  0;
	        $gst_rate =  (isset($tax_invc_items_hsn_data[$tx-1]['gst']) && !empty($tax_invc_items_hsn_data[$tx-1]['gst']))?$tax_invc_items_hsn_data[$tx-1]['gst']:'0.00';
	        $gst_amount =  (isset($tax_invc_items_hsn_data[$tx-1]['gst_amount']) && !empty($tax_invc_items_hsn_data[$tx-1]['gst_amount']))?$tax_invc_items_hsn_data[$tx-1]['gst_amount']:'0.00';
	        $cgst_amount =  0;
	        $sgst_amount =  0;
	        $amount_with_gst = $amount + $gst_amount;
	        }
	        $CI->excel->getActiveSheet()->setCellValue('A'.$i, '');
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($leftBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($bottomBorderStyle);
	        
        	$CI->excel->getActiveSheet()->getStyle("B".$i.":G".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('B'.$i.':G'.$i) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->setCellValue('B'.$i, '');
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->applyFromArray($bottomBorderStyle);
        	
        	$CI->excel->getActiveSheet()->getStyle("H".$i.":I".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('H'.$i.':I'.$i)->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->setCellValue('H'.$i, '');
        	$CI->excel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	$CI->excel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->applyFromArray($rightBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('H'.$i.':I'.$i)->applyFromArray($bottomBorderStyle);
        	
        	if($gst_type == 'intra-state'){
        	$CI->excel->getActiveSheet()->getStyle("J".$i.":K".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('J'.$i.':K'.$i)->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($allborders);
        	$CI->excel->getActiveSheet()->setCellValue('J'.$i, $sgst_rate.' (%)');
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	
        	$CI->excel->getActiveSheet()->setCellValue('L'.$i, $sgst_amount);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($rightBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($leftBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($topBorderStyle);
	        $CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($bottomBorderStyle);
	        $total_hsn_amount +=$sgst_amount; 
        	}else{
        	$CI->excel->getActiveSheet()->getStyle("J".$i.":K".$i)->getAlignment()->setWrapText(true);
        	$CI->excel->getActiveSheet()->mergeCells('J'.$i.':K'.$i)->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($rightBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($leftBorderStyle);
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->applyFromArray($bottomBorderStyle);
        	$CI->excel->getActiveSheet()->setCellValue('J'.$i, '');
        	$CI->excel->getActiveSheet()->getStyle('J'.$i.':K'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	
        	$CI->excel->getActiveSheet()->setCellValue('L'.$i, '');
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($rightBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($leftBorderStylethk);
        	$CI->excel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($bottomBorderStyle);
	        }
        	}
            $i++;
        }    
	}else{
	    $rw2 = $count + 8;
	    $CI->excel->getActiveSheet()->setCellValue('A'.$rw2, 'Sr.no.');
        $CI->excel->getActiveSheet()->getStyle('A'.$rw2)->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->getStyle('A'.$rw2)->applyFromArray($leftBorderStylethk);
        	
        $CI->excel->getActiveSheet()->getStyle("B".$rw2.":G".$rw2)->getAlignment()->setWrapText(true);
        $CI->excel->getActiveSheet()->mergeCells('B'.$rw2.':G'.$rw2) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        $CI->excel->getActiveSheet()->getStyle('B'.$rw2.':G'.$rw2)->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('B'.$rw2, '');
        $CI->excel->getActiveSheet()->getStyle('B'.$rw2.':G'.$rw2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        	
        $CI->excel->getActiveSheet()->getStyle("H".$rw2.":I".$rw2)->getAlignment()->setWrapText(true);
        $CI->excel->getActiveSheet()->mergeCells('H'.$rw2.':I'.$rw2) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        $CI->excel->getActiveSheet()->getStyle('H'.$rw2.':I'.$rw2)->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('H'.$rw2, '');
        $CI->excel->getActiveSheet()->getStyle('H'.$rw2.':I'.$rw2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $CI->excel->getActiveSheet()->getStyle("J".$rw2.":K".$rw2)->getAlignment()->setWrapText(true);
        $CI->excel->getActiveSheet()->mergeCells('J'.$rw2.':K'.$rw2) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
        $CI->excel->getActiveSheet()->getStyle('J'.$rw2.':K'.$rw2)->applyFromArray($allborders);
        $CI->excel->getActiveSheet()->setCellValue('J'.$rw2, '');
        $CI->excel->getActiveSheet()->getStyle('J'.$rw2.':K'.$rw2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        
        $CI->excel->getActiveSheet()->setCellValue('L'.$rw2, '');
        $CI->excel->getActiveSheet()->getStyle('L'.$rw2)->applyFromArray($rightBorderStylethk);
        $CI->excel->getActiveSheet()->getStyle('L'.$rw2)->applyFromArray($leftBorderStylethk);
        $CI->excel->getActiveSheet()->getStyle('L'.$rw2)->applyFromArray($topBorderStyle);
        $CI->excel->getActiveSheet()->getStyle('L'.$rw2)->applyFromArray($bottomBorderStyle);
    }
    if(isset($tax_invc_items_hsn_data) && !empty($tax_invc_items_hsn_data)){ $newcount = (count($tax_invc_items_hsn_data)) + $count + 8;}else{ $newcount = $count+9;}
    $CI->excel->getActiveSheet()->getStyle("A".$newcount.":K".$newcount)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.$newcount.':K'.$newcount) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.$newcount.':K'.$newcount)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$newcount.':K'.$newcount)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$newcount.':K'.$newcount)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$newcount.':K'.$newcount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->setCellValue('A'.$newcount,'');
	
	$CI->excel->getActiveSheet()->setCellValue('L'.$newcount, $total_hsn_amount);
    $CI->excel->getActiveSheet()->getStyle('L'.$newcount)->applyFromArray($rightBorderStylethk);
    $CI->excel->getActiveSheet()->getStyle('L'.$newcount)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->getStyle('L'.$newcount)->applyFromArray($topBorderStylethk);
    $CI->excel->getActiveSheet()->getStyle('L'.$newcount)->applyFromArray($bottomBorderStyle);
    
    for($k=($newcount+1);$k<($newcount+3);$k++){
        if($k == $newcount){
        $CI->excel->getActiveSheet()->getStyle("A".$k.":L".$k)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('A'.$k.':L'.$k) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($topBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($rightBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($leftBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($bottomBorderStyle);
    	$CI->excel->getActiveSheet()->setCellValue('A'.$k, '');
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        }elseif($k == ($newcount+1)){
        $CI->excel->getActiveSheet()->getStyle("A".$k.":L".$k)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('A'.$k.':L'.$k) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->setCellValue('A'.$k, '');
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($leftBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($rightBorderStylethk);
        }elseif($k == ($newcount+2)){
        $CI->excel->getActiveSheet()->getStyle("A".$k.":L".$k)->getAlignment()->setWrapText(true);
    	$CI->excel->getActiveSheet()->mergeCells('A'.$k.':L'.$k) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    	$CI->excel->getActiveSheet()->setCellValue('A'.$k, '');
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($leftBorderStylethk);
    	$CI->excel->getActiveSheet()->getStyle('A'.$k.':L'.$k)->applyFromArray($rightBorderStylethk);
        }
	}
    
    $count = $newcount+3;
    $lm = $count;
	$CI->excel->getActiveSheet()->getStyle("A".$lm.":I".$lm)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm.':I'.$lm) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm.':I'.$lm)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm.':I'.$lm)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm, 'BANK DETAILS:');
    
    $CI->excel->getActiveSheet()->getStyle("J".$lm.":L".$lm)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J'.$lm.':L'.$lm) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('J'.$lm, '');
	$CI->excel->getActiveSheet()->getStyle('J'.$lm)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm.':L'.$lm)->applyFromArray($rightBorderStylethk);
		    
	$lm1 = $count+1;
	$CI->excel->getActiveSheet()->getStyle("A".$lm1.":I".$lm1)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm1.':I'.$lm1) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm1.':I'.$lm1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm1.':I'.$lm1)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm1, 'Bank Name: '.$bank_name);
    
    $lm2 = $count+2;
	$CI->excel->getActiveSheet()->getStyle("A".$lm2.":I".$lm2)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm2.':I'.$lm2) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm2.':I'.$lm2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm2.':I'.$lm2)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm2, 'Account No: '.$bank_acc);
    
    $lm3 = $count+3;
	$CI->excel->getActiveSheet()->getStyle("A".$lm3.":I".$lm3)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm3.':I'.$lm3) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm3.':I'.$lm3)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm3.':I'.$lm3)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm3, 'IFSC Code: '.$ifsccode);
    
    $lm4 = $count+4;
	$CI->excel->getActiveSheet()->getStyle("A".$lm4.":I".$lm4)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm4.':I'.$lm4) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm4.':I'.$lm4)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm4.':I'.$lm4)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm4, 'Branch Address: '.$branch_addr);
    
    $lm5 = $count+5;
	$CI->excel->getActiveSheet()->getStyle("A".$lm5.":I".$lm5)->getAlignment()->setWrapText(true);
    $CI->excel->getActiveSheet()->mergeCells('A'.$lm5.':I'.$lm5) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
    $CI->excel->getActiveSheet()->getStyle('A'.$lm5.':I'.$lm5)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
    $CI->excel->getActiveSheet()->getStyle('A'.$lm5.':I'.$lm5)->applyFromArray($leftBorderStylethk);
    $CI->excel->getActiveSheet()->setCellValue('A'.$lm5, '');
    
    
	$CI->excel->getActiveSheet()->getStyle("J".$lm1.":L".$lm1)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J'.$lm1.':L'.$lm1) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('J'.$lm1, 'For '.$companynamef);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$lm6 = $lm1 + 3;
	$CI->excel->getActiveSheet()->getStyle("J".$lm1.":L".$lm6)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J'.$lm1.':L'.$lm6) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm1.':L'.$lm6)->applyFromArray($bottomBorderStyle);
	
    $lm7 = $lm6 + 1;
	$CI->excel->getActiveSheet()->getStyle("J".$lm7.":L".$lm7)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('J'.$lm7.':L'.$lm7) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->setCellValue('J'.$lm7, 'Authorised Signatory');
	$CI->excel->getActiveSheet()->getStyle('J'.$lm7)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm7.':L'.$lm7)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('J'.$lm7.':L'.$lm7)->applyFromArray($rightBorderStylethk);
	
	$lm8 = $lm7 + 1;
	$CI->excel->getActiveSheet()->getStyle("A".$lm8.":L".$lm8)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.$lm8.':L'.$lm8) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.$lm8.':L'.$lm8)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm8.':L'.$lm8)->applyFromArray($topBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm8.':L'.$lm8)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm8.':L'.$lm8)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('A'.$lm8, $faddr);
	
	$lm9 = $lm8 + 1;
	$CI->excel->getActiveSheet()->getStyle("A".$lm9.":L".$lm9)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.$lm9.':L'.$lm9) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.$lm9.':L'.$lm9)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm9.':L'.$lm9)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm9.':L'.$lm9)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('A'.$lm9, $fdets);
	
	$lm10 = $lm9 + 1;
	$CI->excel->getActiveSheet()->getStyle("A".$lm10.":L".$lm10)->getAlignment()->setWrapText(true);
	$CI->excel->getActiveSheet()->mergeCells('A'.$lm10.':L'.$lm10) ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEEEE');
	$CI->excel->getActiveSheet()->getStyle('A'.$lm10.':L'.$lm10)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm10.':L'.$lm10)->applyFromArray($rightBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm10.':L'.$lm10)->applyFromArray($leftBorderStylethk);
	$CI->excel->getActiveSheet()->getStyle('A'.$lm10.':L'.$lm10)->applyFromArray($bottomBorderStylethk);
	$CI->excel->getActiveSheet()->setCellValue('A'.$lm10, $fweb);
	
	if($type == 'tax'){
	$tax_invc_no =  (isset($tax_invc_data->tax_invc_no) && !empty($tax_invc_data->tax_invc_no))?$tax_invc_data->tax_invc_no:'0';
	$filename=$tax_invc_no."_TAX_INVOICE_FORMAR_1.xls";
	}else{
	$tax_invc_no =  (isset($tax_invc_data->proforma_no) && !empty($tax_invc_data->proforma_no))?$tax_invc_data->proforma_no:'0';
	$filename=$tax_invc_no."_PROFORMA_INVOICE_FORMAR_1.xls";
	}
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename='.$filename); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	header('Cache-Control: max-age=1');
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	header ('Cache-Control: cache, must-revalidate');
	header ('Pragma: public');
	$objWriter = PHPExcel_IOFactory::createWriter($CI->excel, 'Excel5');
	$objWriter->save('php://output'); 
    }
}
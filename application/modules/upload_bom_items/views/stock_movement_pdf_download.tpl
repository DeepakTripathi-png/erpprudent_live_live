
<table   style="border:1px solid gray;padding: 15px 15px 15px 8px; ">
   <tbody>
   <tr style="padding: 0px; ">
      <td colspan="6" style="font-weight: bold; font-size: 12px; text-align: center; border-bottom: 1px solid gray;">
        <span >Stock Movement</span>
      </td>
    </tr>
   	  <tr >
         <td colspan="2" style="font-size: 10px;border-bottom:1px solid gray;" >
         	<span style="font-weight: bold;font-size: 10px; ">Stock Movement No. :- </span><br>
         	<span style="font-size: 10px;"><?php echo $data[0]['sm_number']; ?></span>
         </td>
         <td colspan="2" style="font-size: 10px;border-bottom:1px solid gray;"><span style="font-weight: bold;">Form Project :- &nbsp; </span><br><span style="font-size: 10px;"><?php echo $data[0]['form_project']; ?></span></td>
    
        <td colspan="2"  style="font-size: 10px;border-bottom:1px solid gray;"><span style="font-weight: bold;font-size: 10px;">Po Number. :- &nbsp;</span><br>
         <span style="font-size: 10px;"><?php echo $data[0]['po_number']; ?></span></td>
      </tr>

       <tr >
         <td colspan="2" style="font-size: 10px;border-bottom:1px solid gray;" >
         	<span style="font-weight: bold;font-size: 10px; ">VDC Number. :- </span><br>
         	<span style="font-size: 10px;"><?php echo $data[0]['vdc_number']; ?></span>
         </td>
         <td colspan="2" style="font-size: 10px;border-bottom:1px solid gray;"><span style="font-weight: bold;">Form Projct Bom Code :- &nbsp; </span><br><span style="font-size: 10px;"><?php echo $data[0]['form_bom_code']; ?></span></td>
    
        <td colspan="2"  style="font-size: 10px;border-bottom:1px solid gray;"><span style="font-weight: bold;font-size: 10px;">SM Date. :- &nbsp;</span><br>
         <span style="font-size: 10px;"><?php echo $data[0]['stock_date']; ?></span></td>
      </tr>
      <tr >
         <td colspan="2"  style="font-size: 10px;border-bottom:1px solid gray;"><span style="font-weight: bold;font-size: 10px;">To project. :- &nbsp;</span><br>
         <span style="font-size: 10px;"><?php echo $data[0]['to_project']; ?></span></td>
         <td colspan="2" style="font-size: 10px;border-bottom:1px solid gray;"><span style="font-weight: bold;">To Project Bom Code :- &nbsp; </span><br><span style="font-size: 10px;"><?php echo $data[0]['to_bom_code']; ?></span></td>
    
        <td colspan="2"  style="font-size: 10px;border-bottom:1px solid gray;"></td>
      </tr>
   
   
   </tbody>
</table>
<br>

<table style="border:1px solid gray;" cellpadding="5">
   <tbody>
      <tr style="border:1px solid gray;">
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%" align="center">Sr. No.</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="20%">Item Description</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">BOM Code</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">HNS/SAC Code</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="15%">Make</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="15%">Model</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Unit</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Qty</th>
      
      </tr>
      
      <?php 
        $total_movement_qty = 0;
        foreach($data as $key=>$val){
        $total_movement_qty += $val['stock_qty'];
         ?>
      <tr>
         <td style="border:1px solid gray;" width="10%" align="center"><?php echo $key+1; ?></td>
         <td style="border:1px solid gray;" width="20%"><?php echo $val['item_description']; ?></td>
         <td style="border:1px solid gray;" width="10%"><?php echo $val['bom_code']; ?></td>
         <td style="border:1px solid gray;" width="10%"><?php echo $val['hsn_code'] ?></td>
         <td style="border:1px solid gray;" width="15%"><?php echo $val['make']; ?> </td>
         <td style="border:1px solid gray;" width="15%"><?php echo $val['model']; ?> </td>
         <td style="border:1px solid gray;" width="10%"><?php echo $val['unit']; ?></td>
         <td style="border:1px solid gray;" width="10%"><?php echo $val['stock_qty']; ?></td>
   
      </tr>
      <?php } ?>

   </tbody>
</table>


<table style="border:1px solid gray;" cellpadding="5">
    <br>
<br>
   <tbody>
      <tr style="border:1px solid gray;">
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%" align="center">Sr. No.</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="20%">Item Description</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">BOM Code</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">HNS/SAC Code</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="15%">Make</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="15%">Model</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Unit</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Qty</th>
      
      </tr>
      
      <tr>
         <td style="border:1px solid gray;" width="10%" align="center"><?php echo 1; ?></td>
         <td style="border:1px solid gray;" width="20%"><?php echo $sm_data[0]['item_description']; ?></td>
         <td style="border:1px solid gray;" width="10%"><?php echo $sm_data[0]['bom_code']; ?></td>
         <td style="border:1px solid gray;" width="10%"><?php echo $sm_data[0]['hsn_code'] ?></td>
         <td style="border:1px solid gray;" width="15%"><?php echo $sm_data[0]['make']; ?> </td>
         <td style="border:1px solid gray;" width="15%"><?php echo $sm_data[0]['model']; ?> </td>
         <td style="border:1px solid gray;" width="10%"><?php echo $sm_data[0]['unit']; ?></td>
         <td style="border:1px solid gray;" width="10%"><?php echo $total_movement_qty; ?></td>
   
      </tr>
      

   </tbody>
</table>
<table   style="border:1px solid gray;padding: 15px 15px 15px 8px; ">
  <tbody>
    <tr >
      <td colspan="2"  style="border-bottom:1px solid gray;font-size: 10px;">
        <span style="font-weight: bold;">For Prudent EPC Pvt. Ltd.</span><br>
        <img src="<?php echo base_url();?>uploads/images/stamp.png" width="70" height="70"><br>
        <span style="font-weight: bold;">Authorised Signatory</span>
      </td>
      <td colspan="2" style="border-bottom:1px solid gray;font-size: 10px;">

      </td>
    </tr>
  </tbody>
</table>

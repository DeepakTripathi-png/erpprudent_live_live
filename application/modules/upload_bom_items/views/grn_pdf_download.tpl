
<table   style="border:1px solid gray;padding: 15px 15px 15px 8px; ">
   <tbody>
   <tr style="padding: 0px; ">
      <td colspan="6" style="font-weight: bold; font-size: 12px; text-align: center; border-bottom: 1px solid gray;">
        <span >Goods Received Notes</span>
      </td>
    </tr>
   	  <tr >
         <td colspan="2" style="font-size: 10px;border-bottom:1px solid gray;" >
         	<span style="font-weight: bold;font-size: 10px; ">Purchase Order No.</span><br>
         	<span style="font-size: 10px;"><?php echo $bom_data[0]['po_number']; ?></span>
         </td>
         
         <td colspan="2"  style="font-size: 10px;border-bottom:1px solid gray;"><span style="font-weight: bold;font-size: 10px;">GRN No.</span><br><span style="font-size: 10px;"><?php echo $bom_data[0]['grn_number']; ?></span></td>
         <td colspan="2" style="font-size: 10px;border-bottom:1px solid gray;"><span style="font-weight: bold;">Date </span><br><span style="font-size: 10px;"><?php echo $bom_data[0]['grn_date']; ?></span></td>
    
      </tr>
      <tr >
         <td colspan="6"  style="border-bottom:1px solid gray;font-size: 10px;">
         	<span style="font-weight: bold;">To, </span>
         	<br>
         	<span style="font-size: 10px;"><?php echo $project_data->work_order_on; ?> </span>
         <br> <br>
          <span style="font-weight: bold;">Form, </span>
         	<br><br>
         	<span style="font-weight: bold;font-size: 10px;">Vendor Name :- &nbsp; </span>	<span style="font-size: 10px;"><?php echo $vendor_data->name_of_company; ?></span>
         	<br>
            <span style="font-weight: bold;font-size: 10px;">Project Name :- &nbsp;</span><span style="font-size: 10px;"><?php echo $project_data->bp_code; ?></span>
         
         	<br>
         	<span style="font-weight: bold;font-size: 10px;">GST No :- &nbsp; </span><span style="font-size: 10px;"><?php echo $vendor_data->gst_registration_no; ?></span>
         	<br>
         	<span style="font-weight: bold;font-size: 10px;">Address :- &nbsp;</span><span style="font-size: 10px;"><?php echo $vendor_data->reg_house_building_no." ".$vendor_data->reg_street." ".$vendor_data->reg_city_post_code." ".$vendor_data->reg_state; ?></span>
         
         </td>
      </tr>
     
   </tbody>
</table>
<br>

<table style="border:1px solid gray;" cellpadding="5">
   <tbody>
      <tr style="border:1px solid gray;">
         <!-- <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="5%" align="center">Sr. No.</th> -->
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="7%">BOM Code</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="21%">Item Description</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">HNS Code</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Make</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="9%">Model</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="6%">Unit</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="7%">DC Qty</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Rate</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="7%">Gst</th>
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="13%">Amount</th>
      </tr>
      <?php foreach($bom_data as $key=>$val){
         ?>
      <tr>
         <!-- <td style="border:1px solid gray;" width="4%" align="center"><?php echo $key+1; ?></td> -->
         <td style="border:1px solid gray;" width="7%"><?php echo $val['bom_code']; ?></td>
         <td style="border:1px solid gray;" width="21%"><?php echo $val['item_description']; ?></td>
         <td style="border:1px solid gray;" width="10%"><?php echo $val['hsn_sac_code'] ?></td>
         <td style="border:1px solid gray;" width="10%"><?php echo $val['make']; ?> </td>
         <td style="border:1px solid gray;" width="9%"><?php echo $val['model']; ?> </td>
         <td style="border:1px solid gray;" width="6%"><?php echo $val['unit']; ?></td>
         <td style="border:1px solid gray;" width="7%" ><?php echo number_format($val['grn_qty'],2); ?></td>
         <td style="border:1px solid gray;" width="10%"><?php echo number_format($val['basic_rate'],2); ?></td>
         <td style="border:1px solid gray;" width="7%"><?php echo number_format($val['gst'],2); ?></td>
         <td style="border:1px solid gray;" width="13%"><?php echo number_format($val['total_amount'],2); ?></td>
      </tr>
      <?php } ?>

   </tbody>
</table>
<br>
<table style="border:1px solid gray;" cellpadding="5">
   <tbody>
      <tr>
         <td colspan="8" style="border:1px solid gray;font-weight: bold" width="87%">Subtotal</td>
         <td style="border:1px solid gray;" width="13%"><?php echo number_format($fAmount,2); ?></td>
      </tr>
      <tr>
         <td colspan="8" style="border:1px solid gray;font-weight: bold" width="87%">CGST(<?php echo $cgst; ?>)</td>
         <td style="border:1px solid gray;" width="13%"><?php echo number_format($fcgst_amount,2); ?></td>
      </tr>
      <tr>
         <td colspan="8" style="border:1px solid gray;;font-weight: bold" width="87%">SGST(<?php echo $sgst; ?>)</td>
         <td style="border:1px solid gray;" width="13%"><?php echo number_format($fsgst_amount,2); ?></td>
      </tr>
      <tr>
         <td colspan="8" style="border:1px solid gray;;font-weight: bold" width="87%">IGST(<?php echo $igst; ?>)</td>
         <td style="border:1px solid gray;" width="13%"><?php echo number_format($figst_amount,2); ?></td>
      </tr>
      <tr>
         <td colspan="8" style="border:1px solid gray;font-weight: bold" width="87%">Total with GST</td>
         <td style="border:1px solid gray;" width="13%"><?php echo number_format($ftotal_amount,2); ?></td>
      </tr>
      <tr>
         <td colspan="8" style="border:1px solid gray;font-weight: bold" width="87%">Advance Payment</td>
         <td style="border:1px solid gray;" width="13%"><?php echo number_format(floatval($advance_payment),2); ?></td>
      </tr>
      <tr>
         <td colspan="8" style="border:1px solid gray;font-weight: bold" width="87%">Balance Payment</td>
         <td style="border:1px solid gray;" width="13%"><?php echo number_format($ftotal_amount - floatval($advance_payment) ,2); ?></td>
      </tr>
      
   </tbody>
</table>
<table   style="border:1px solid gray;padding: 15px 15px 15px 8px; ">
  <tbody>
    <tr >
      <td colspan="2"  style="border-bottom:1px solid gray;font-size: 10px;">
        <span style="font-weight: bold;">Bill To </span><br>
        Prudent EPC Pvt. Ltd.<br>
        5th floor, 509 B wing, Golf<br>
        Scappe, Sion Trombay, Road,<br>
        Chembur, Mumbai -400071<br>
        GST No- 27AAKCP4656L1Zs
      </td>
      <td colspan="2" style="border-bottom:1px solid gray;font-size: 10px;">
        <span style="font-weight: bold;">Ship To </span><br>
        <?php echo $project_data->site_address; ?>
      </td>
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
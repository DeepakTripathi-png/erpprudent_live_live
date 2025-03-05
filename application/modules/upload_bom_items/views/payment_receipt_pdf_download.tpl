<table   style="border:1px solid gray;padding: 15px 15px 15px 8px; ">
  <tbody>
    <tr style="padding: 0px; ">
      <td colspan="6" style="font-weight: bold; font-size: 12px; text-align: center; border-bottom: 1px solid gray;">
        <span >Payment Receipt</span>
      </td>
    </tr>

    <tr style="padding:0px;border:1px solid gray;">
        <td colspan="2" style="font-size: 10px;"><span style="font-weight: bold;">Purchase Order No :- &nbsp; </span><br><span style="font-size: 10px;"><?php echo $bom_data[0]['po_number']; ?></span></td>
        <td colspan="2" style="font-size: 10px;"><span style="font-weight: bold;">Proforma Invoice No :- &nbsp; </span><br><span style="font-size: 10px;"><?php echo $bom_data[0]['proforma_no']; ?></span></td>
        <td colspan="2" style="font-size: 10px;"><span style="font-weight: bold;">Date :- &nbsp; </span><br><span style="font-size: 10px;"><?php echo $pr_data['payment_date']; ?></span></td>
      </tr>
     
    </tbody>
  </table>
  <table   style="border:1px solid gray; " cellpadding="3">
  <tbody>
    <tr style="padding:0px">
        <td  style="font-size: 10px;"><span style="font-weight: bold;"><br>To, &nbsp; </span></td>
        </tr>
        <tr style="padding:0px">
        <td  style="font-size: 10px;"><span style="font-weight: bold;">Vendor Name :- &nbsp; </span><span style="font-size: 10px;"><?php echo $vendor_data->name_of_company; ?></span></td>
        </tr>
        <tr style="padding:0px">
        <td  style="font-size: 10px;"><span style="font-weight: bold;">Address :- &nbsp; </span><span style="font-size: 10px;"><?php echo $vendor_data->reg_house_building_no.", ".$vendor_data->reg_street.", ".$vendor_data->reg_city_post_code.", ".$vendor_data->reg_state.", ".$vendor_data->reg_country; ?></span></td>
        </tr>
        <tr style="padding:0px">
        <td  style="font-size: 10px;"><span style="font-weight: bold;">GST No :- &nbsp; </span><span style="font-size: 10px;"><?php echo $vendor_data->gst_registration_no; ?></span></td>
        </tr>
        <tr style="padding:0px">
        <td  style="font-size: 10px;"><span style="font-weight: bold;">Project Name :- &nbsp; </span><span style="font-size: 10px;"><?php echo $project_data->bp_code; ?></span> <br></td>
        </tr>
       
    </tbody>
  </table>
  <table style="border:1px solid gray;" cellpadding="5">
  <tbody>
    <tr style="border:1px solid gray;">
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="5%" align="center"><br>Sr. No.</th>
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="15%">Item Description</th>
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="8%">BOM Code</th>
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">HNS/SAC Code</th>
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Make</th>
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="9%">Model</th>
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="9%">Unit</th>
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Qty</th>
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="11%">Rate</th>
      <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="13%">GST</th>
    </tr>
    <?php foreach($bom_data as $key=>$val){
      ?>
      <tr>
        <td style="border:1px solid gray;" width="5%" align="center"><?php echo $key+1; ?></td>
        <td style="border:1px solid gray;" width="15%"><?php echo $val['item_description']; ?></td>
        <td style="border:1px solid gray;" width="8%"><?php echo $val['bom_code']; ?></td>
        <td style="border:1px solid gray;" width="10%"><?php echo $val['hsn_code'] ?></td>
        <td style="border:1px solid gray;" width="10%"><?php echo $val['make']; ?> </td>
        <td style="border:1px solid gray;" width="9%"><?php echo $val['model']; ?> </td>
        <td style="border:1px solid gray;" width="9%"><?php echo $val['unit']; ?></td>
        <td style="border:1px solid gray;" width="10%" ><?php echo number_format($val['qty'],2); ?></td>
        <td style="border:1px solid gray;" width="11%"><?php echo number_format($val['amount'],2); ?></td>
        <td style="border:1px solid gray;" width="13%"><?php echo number_format($val['gst'],2); ?></td>
      </tr>
    <?php } ?>

  </tbody>
</table>
<table style="border:1px solid gray;" cellpadding="5">
  <tbody>
    
    <tr>
      <td  style="border:1px solid gray;font-weight: bold" >CGST(<?php echo $bom_data[0]['cgst']; ?>)</td>
      <td  style="border:1px solid gray;" ><?php echo number_format($fcgst_amount,2); ?></td>
      <td  style="border:1px solid gray;;font-weight: bold" >SGST(<?php echo $bom_data[0]['sgst']; ?>)</td>
      <td style="border:1px solid gray;" ><?php echo number_format($fsgst_amount,2); ?></td>
      <td  style="border:1px solid gray;;font-weight: bold" >IGST(<?php echo $bom_data[0]['igst']; ?>)</td>
      <td style="border:1px solid gray;" ><?php echo number_format($figst_amount,2); ?></td>
    </tr>
    <tr>
      <td colspan="2" style="border:1px solid gray;font-weight: bold" >Total without GST</td>
      <td colspan="1"style="border:1px solid gray;" ><?php echo number_format($fAmount,2); ?></td>
   
      <td colspan="2" style="border:1px solid gray;font-weight: bold" >Total with GST</td>
      <td colspan="1" style="border:1px solid gray;" ><?php echo number_format($ftotal_amount,2); ?></td>
    </tr>
    <tr>
      <td  style="border:1px solid gray;font-weight: bold" >Advance Payment <?php echo " (".$pr_data['payment_percent']." %)"; ?></td>
      <td style="border:1px solid gray;" ><?php echo number_format($pr_data['payment_amount'],2); ?></td>
   
      <td  style="border:1px solid gray;font-weight: bold" >Gst Amount</td>
      <td style="border:1px solid gray;" ><?php echo number_format($pr_data['gst_amount'],2); ?></td>
    
      <td  style="border:1px solid gray;font-weight: bold" >Total Advance Payable Amount</td>
      <td style="border:1px solid gray;" ><?php echo number_format($pr_data['payment_amount']+$pr_data['gst_amount'],2); ?></td>
      </tr>
      <!-- <tr>
      <td  style="border:1px solid gray;font-weight: bold" width="80%" >Balance Amount</td>
      <td style="border:1px solid gray;" width="20%"><?php echo number_format($ftotal_amount -($pr_data['payment_amount']+$pr_data['gst_amount']),2); ?></td>
    </tr> -->
    <tr>
      <td colspan="10" style="padding: 15px 15px 15px 15px;">
        <br>
       
        <span style="font-weight: bold;font-size: 10px;">Terms and Condition</span>
        <br>
<span style="font-size: 10px;"><?php echo $bom_data[0]['terms_and_condition']; ?></span><br>


  
      </td>
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
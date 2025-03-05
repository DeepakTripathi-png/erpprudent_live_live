
<table   style="border:1px solid gray;padding: 15px 15px 15px 8px; ">
   <tbody>
   <tr style="padding: 0px; ">
      <td colspan="6" style="font-weight: bold; font-size: 12px; text-align: center; border-bottom: 1px solid gray;">
        <span ><?php echo $data['voucher_type']; ?></span>
      </td>
    </tr>
   	  <tr >
         <td colspan=" <?php if($data['voucher_type'] == 'Office Expense'){ echo 2;}else{
            echo 3;
         }  ?>" style="font-size: 10px;border-bottom:1px solid gray;" >
         	<span style="font-weight: bold;font-size: 10px; ">Name :- </span>
         	<span style="font-size: 10px;"><?php echo $data['fullname']; ?></span>
         </td>
         <td colspan=" <?php if($data['voucher_type'] == 'Office Expense'){ echo 2;}else{
            echo 3;
         }  ?>" style="font-size: 10px;border-bottom:1px solid gray;"><span style="font-weight: bold;">Budget Date :-  </span><span style="font-size: 10px;"><?php echo date('Y-m-d', strtotime($data['voucher_date'])); ?>         </span></td>
         
        
         <?php if($data['voucher_type'] == 'Office Expense'){ ?>
         <td colspan="2"  style="font-size: 10px;border-bottom:1px solid gray;">
         <span style="font-weight: bold;font-size: 10px; ">Financial Year :- </span>
         <span style="font-size: 10px;"><?php echo $data['financial_year']; ?></span>
         </td>
         <?php } ?>
        
      </tr>
   
      <tr >
         <td colspan="6"  style="font-size: 10px;text-align:center">
         	<span>Budget Details</span>
         </td>
      </tr>
   </tbody>
</table>
<br>

<table style="border:1px solid gray;" cellpadding="5">
   <tbody>
      <tr style="border:1px solid gray;">
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" align="center">Sr. No.</th>
         <!-- <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" >Budget Date</th> -->
         
         <?php if($data['voucher_type'] == 'Project Expense'){ ?>
            <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" >BP Code</th>
         <?php } ?>
         
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" >Voucher Type</th>
         
         <?php if($data['voucher_type'] != 'Project Expense'){ ?>
            <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" >Head</th>
         <?php } ?>
         
         <?php if($data['voucher_type'] == 'Project Expense'){ ?>
            <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" >BOM Code</th>
            <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" >Description</th>
            <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" >Qty</th>
            <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" >Rate</th>
         <?php } ?>
         
         <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" >Amount</th>
      </tr>
      
      <tr>
         <td style="border:1px solid gray;"  align="center">1</td>
         <!-- <td style="border:1px solid gray;" ><?php echo $data['voucher_date']; ?></td> -->
         
         <?php if($data['voucher_type'] == 'Project Expense'){ ?>
            <td style="border:1px solid gray;" ><?php echo $data['bp_code']; ?></td>
         <?php } ?>
         
         <td style="border:1px solid gray;" ><?php echo $data['voucher_type']; ?></td>
         
         <?php if($data['voucher_type'] != 'Project Expense'){ ?>
            <td style="border:1px solid gray;" ><?php echo $data['head']; ?></td>
         <?php } ?>
         <?php if($data['voucher_type'] == 'Project Expense'){ ?>
            <td style="border:1px solid gray;" ><?php echo $data['v_bom_code']; ?></td>
            <td style="border:1px solid gray;" ><?php echo $data['description']; ?></td>
            <td style="border:1px solid gray;" ><?php echo $data['qty']; ?></td>
            <td style="border:1px solid gray;" ><?php echo $data['rate']; ?></td>
         <?php } ?>
         
         <td style="border:1px solid gray; text-align: right;" ><?php echo number_format($data['amount'], 2); ?></td>
      </tr>
   </tbody>
   
</table>
<br>
<table style="border:1px solid gray; border-collapse:collapse; width:100%;" cellpadding="5">
   <tbody>
      <tr>
         <td colspan="4" style="border:1px solid gray; font-weight: bold; text-align: right;">Total</td>
         <td style="border:1px solid gray; text-align: right;"><?php echo number_format($data['amount'], 2); ?></td>
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


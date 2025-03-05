
<table   style="border:1px solid gray;padding: 15px 15px 15px 8px; ">
  <tbody>
    <tr style="padding: 0px; ">
      <td colspan="6" style="font-weight: bold; font-size: 12px; text-align: center; border-bottom: 1px solid gray;">
        <span >Delivery Challan</span>
      </td>
    </tr>

    <tr style="padding:0px">
      <td colspan="2"  >
        <span style="font-weight: bold;font-size: 10px;">Prudent EPC Pvt Ltd</span><br>
        <span style="font-size: 10px;">91/B, Opp. Vishal Tower 2,<br>
          Kamgar Nagar, Kurla East,<br>
          Mumbai - 400 024 </span><br>
          <span style="font-weight: bold;font-size: 10px;">GST No: 27AAKCP4656L1ZS
          </span>
        </td>
        <td colspan="2" style="font-size: 10px;"><span style="font-weight: bold;">Delivery Challan Date :- &nbsp; </span><span style="font-size: 10px;"><?php echo $bom_data[0]['dc_date']; ?></span></td>
        <td colspan="2" style="font-size: 10px;"><span style="font-weight: bold;">Delivery Challan No :- &nbsp; </span><span style="font-size: 10px;"><?php echo $bom_data[0]['vdc_number']; ?></span></td>
      </tr>
    </tbody>
  </table>
  <table   style="border:1px solid gray;" cellpadding="3">
    <tbody>
      <tr>
        <td colspan="3" rowspan="4" style="font-size: 10px;">
        <span style="font-weight: bold;">Site Address :-</span><br>
          <span style="font-size: 10px;"><?php echo $bom_data[0]['site_address']; ?></span>
        </td>
        <td colspan="3" style="font-size: 10px;">
        <span style="font-weight: bold;">BP Code :-</span>
          <span style="font-size: 10px;"><?php echo $project_data->bp_code; ?></span>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="font-size: 10px;">
          <span style="font-weight: bold;">Location :-</span>
          <span style="font-size: 10px;"><?php echo $bom_data[0]['registered_address']; ?></span>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="font-size: 10px;">
          <span style="font-weight: bold;">Vendor Invoice No. :-</span>
          <span style="font-size: 10px;"><?php echo $bom_data[0]['suppliers_ref']; ?></span>
        </td>
      </tr>
      <tr>
        <td colspan="3" style="font-size: 10px;">
          <span style="font-weight: bold;">Vendor DC No :-</span>
          <span style="font-size: 10px;"><?php echo $bom_data[0]['dispatch_document_no']; ?></span><br>
        </td>
      </tr>
    </tbody>
  </table>

  <table style="border:1px solid gray;" cellpadding="5">
    <tbody>
      <tr style="border:1px solid gray;">
        <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="5%" align="center">Sr. No.</th>
        <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="20%">Item Description</th>
        <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">BOM Code</th>
        <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="15%">HNS/SAC Code</th>
        <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="15%">Make</th>
        <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="15%">Model</th>
        <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Unit</th>
        <th style="border:1px solid gray;background-color: #b6e8f3;font-weight: bold" width="10%">Qty</th>

      </tr>
      <?php foreach($bom_data as $key=>$val){
        ?>
        <tr>
          <td style="border:1px solid gray;" width="5%" align="center"><?php echo $key+1; ?></td>
          <td style="border:1px solid gray;" width="20%"><?php echo $val['item_description']; ?></td>
          <td style="border:1px solid gray;" width="10%"><?php echo $val['bom_code']; ?></td>
          <td style="border:1px solid gray;" width="15%"><?php echo $val['hsn_sac_code'] ?></td>
          <td style="border:1px solid gray;" width="15%"><?php echo $val['make']; ?> </td>
          <td style="border:1px solid gray;" width="15%"><?php echo $val['model']; ?> </td>
          <td style="border:1px solid gray;" width="10%"><?php echo $val['unit']; ?></td>
          <td style="border:1px solid gray;" width="10%" ><?php echo number_format($val['good_condition_qty'],2); ?></td>
        </tr>
      <?php } ?>

    </tbody>
  </table>
  <table  style="border:1px solid gray;" cellpadding="5">
    <tbody style="margin-top: 5px">
      <tr >
        <td colspan="3"  style="font-size: 10px;">
          <span style="font-weight: bold;">Received the above Items in full Quantity </span><br>
          <span style="font-size: 10px;"><?php echo $total_dc_qty; ?></span>
        </td>
        <td colspan="3" rowspan="4"  style="font-size: 10px;">
        <span style="font-weight: bold;">For Prudent EPC Pvt. Ltd. </span><br>
        <img src="<?php echo base_url();?>uploads/images/stamp.png" width="70" height="70"><br>
        <span style="font-weight: bold;">Authorised Signatory</span>
        </td>
      </tr>
      <tr>
        <td colspan="3"  style="font-size: 10px;">
          <span style="font-weight: bold;">Receiver Name</span><br>
          <span style="font-size: 10px;"><?php echo $bom_data[0]['recevier_name']; ?></span>
        </td>
      </tr>
      <tr>
        <td colspan="3"  style="font-size: 10px;">

        </td>
      </tr>
      <tr>
        <td colspan="3"  style="font-size: 10px;">

        </td>
      </tr>

    </tbody>
  </table>
  <table   style="border:1px solid gray;padding: 15px 15px 15px 8px; ">
    <tbody>
      <tr style="padding: 0px; ">
        <td colspan="6" style=" font-size: 10px; text-align: center; border-bottom: 1px solid gray;">
          <span >Compiled & Suggested by</span>
        </td>
      </tr>
      <tr style="padding: 0px; ">
        <td colspan="6" style=" font-size: 10px; text-align: center; border-bottom: 1px solid gray;">
          <span >Corporate Office – 91/B, S. G. Barve Marg, Kamgar Nagar, Kurla(East), Mumbai-400024<br>
            Land Line: +91 22 2522 0676, E: sales@prudentepc.com, accounts@prudentepc.com www.prudentepc.com, CIN :
            U72900MH2019PTC323399</span>
          </td>
        </tr>


      </tbody>
    </table>

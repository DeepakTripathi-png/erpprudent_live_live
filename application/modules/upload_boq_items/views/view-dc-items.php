<style>
table, td, th {
  border: 1px solid;
  padding:1px 5px;
  vertical-align: middle;
  word-wrap: break-word;
}

table {
  width: 100%;
  border-collapse: collapse;
}
.tblhead{
    text-align: center;
    font-weight: 600;
    background: #f5f5f5;
}
.modal-footer{
    display:none;
}
.modal-dialog{
    width:65%;
}
</style>
<?php if(isset($dc_data) && !empty($dc_data)){ 
    $work_order_on =  (isset($dc_data->work_order_on) && !empty($dc_data->work_order_on) && $dc_data->work_order_on == 'Prudent EPC')?'Prudent EPC':'Prudent Controls';
    if($work_order_on == 'Prudent EPC'){
        $companynamef = 'Prudent EPC Private Limited';
    }else{
        $companynamef = 'Prudent Controls Private Limited';    
    }
    $dc_no =  (isset($dc_data->dc_no) && !empty($dc_data->dc_no))?$dc_data->dc_no:'';
    $suppliers_ref =  (isset($dc_data->suppliers_ref) && !empty($dc_data->suppliers_ref))?$dc_data->suppliers_ref:'';
    $consignee_name =  (isset($consignee_data[0]->consignee_name) && !empty($consignee_data[0]->consignee_name))?$consignee_data[0]->consignee_name:'';
    $delivery_address =  (isset($consignee_data[0]->delivery_address) && !empty($consignee_data[0]->delivery_address))?wordwrap($consignee_data[0]->delivery_address,50,"<br>\n"):'';
    $buyer_order_ref =  (isset($dc_data->buyer_order_ref) && !empty($dc_data->buyer_order_ref))?$dc_data->buyer_order_ref:'';
    $dccdate =  (isset($dc_data->dcc_dated) && !empty($dc_data->dcc_dated))?date('d-m-Y',strtotime($dc_data->dcc_dated)):'';
    $dispatch_document_no =  (isset($dc_data->dispatch_document_no) && !empty($dc_data->dispatch_document_no))?$dc_data->dispatch_document_no:'';
    $destination =  (isset($dc_data->destination) && !empty($dc_data->destination))?$dc_data->destination:'';
    $consignee_buyer =  (isset($dc_data->consignee_buyer) && !empty($dc_data->consignee_buyer))?$dc_data->consignee_buyer:'';
    $dispatch_through =  (isset($dc_data->dispatch_through) && !empty($dc_data->dispatch_through))?$dc_data->dispatch_through:'';
    $terms_of_delivery =  (isset($dc_data->terms_of_delivery) && !empty($dc_data->terms_of_delivery))?$dc_data->terms_of_delivery:'';
	
?>
<table width="100%">
    <tr>
        <!-- <td colspan="6" class="tblhead">DELIVERY NOTE</td> -->
        <td colspan="6" class="tblhead"><?php echo $companynamef ; ?></td>
    </tr>
    <tr>
        <!-- <td colspan="2"><?php echo $companynamef; ?></td> -->
        <td colspan="2">91/B, Opp Vishal Tower 2,</td>
        <td colspan="2">Delivery Note No</td>
        <td colspan="2"><?php echo $dc_no; ?></td>
    </tr>
    <tr>
    <td colspan="2">Kamgar Nagar, Kurla East - 400024</td>
        <td colspan="2"></td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <!-- <td colspan="2">Kamgar Nagar, Kurla East - 400024</td> -->
        <td colspan="2"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td colspan="2">Supplier's Ref</td>
        <td colspan="2"><?php echo $suppliers_ref; ?></td>
    </tr>
    <tr>
        <td colspan="2">Consignee</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo $consignee_name; ?></td>
        <td colspan="2">Buyer's Order Ref</td>
        <td>Dated</td>
        <td><?php echo $dccdate; ?></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="3"><?php echo $delivery_address; ?></td>
        <td colspan="4"><?php echo $buyer_order_ref; ?></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="2">Dispatch Document No: <br> <?php echo $dispatch_document_no; ?></td>
        <td colspan="2">Destination</td>
    </tr>
    <tr>
        <td colspan="4"><?php echo $destination; ?></td>
    </tr>
    <tr>
        <td colspan="2">Buyer (Other than Consignee)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo $consignee_buyer; ?></td>
        <td colspan="2">Dispatched Through: </td>
        <td colspan="2"><?php echo $dispatch_through; ?></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="3"></td>
    </tr>
    <tr>
        <td colspan="4">Terms of Delivery</td>
    </tr>
    <tr>
        <td colspan="4"><?php echo $terms_of_delivery; ?></td>
    </tr>
    <tr>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td style="font-weight:700;">Sr No As per BOM</td>
        <td style="font-weight:700;">Sr No As per BOQ</td>
        <td colspan="2" style="font-weight:700;">Description of Goods</td>
        <td style="font-weight:700;">HSN/SAC Code</td>
        <td style="font-weight:700;">Quantity</td>
    </tr>
    <?php if(isset($dc_items_data) && !empty($dc_items_data)){ ?>
        <?php $i=1;foreach($dc_items_data as $key){ 
        $boq_code =  (isset($key->boq_code) && !empty($key->boq_code))?$key->boq_code:'';
        $item_description =  (isset($key->item_description) && !empty($key->item_description))?$key->item_description:'';
	    $qty =  (isset($key->qty) && !empty($key->qty))?$key->qty:'0';
	    $hsn_sac_code =  (isset($key->hsn_sac_code) && !empty($key->hsn_sac_code))?$key->hsn_sac_code:'0';
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $boq_code; ?></td>
            <td colspan="2"><?php echo $item_description; ?></td>
            <td><?php echo $hsn_sac_code; ?></td>
            <td><?php echo $qty; ?></td>
        </tr>
        <?php $i++;} ?>
    <?php } ?>
</table>
<?php } ?>
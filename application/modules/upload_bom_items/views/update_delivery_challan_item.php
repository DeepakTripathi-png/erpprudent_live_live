
<?php 
	foreach ($po_items as $key => $value) { 
		// pr($value,1);
?>
		

<tr class="odd">
   <td>
      <input type="text" class="form-control invaliderror" name="sr_no[]" value="<?php echo $value['sr_no'];  ?>" placeholder="Sr.No" style="font-size: 12px;width:100%" readonly="">
   </td>
   <td>
      <input type="hidden" class="js-req_qty" name="req_qty[]" value="<?php echo $value['req_qty'];  ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly="">
      <input type="hidden" name="vdc_item_id[]" value="<?php echo $value['vdc_item_id'];  ?>"  readonly="">
      <input type="text" class="form-control  js-bom_sr_no" name="bom_code[]" value="<?php echo $value['bom_code'];  ?>" placeholder="BOM Sr. No." style="font-size: 12px;width:100%" readonly="">
   </td>
   <td>
      <input type="text" class="form-control " name="bom_item_description[]" value="<?php echo $value['bom_item_description'];  ?>" placeholder="Item Description" style="font-size: 12px;width:100%" readonly="">
   </td>
   <td>
      <input type="text" class="form-control " name="bom_unit[]" value="<?php echo $value['bom_unit'];  ?>" placeholder="Item Description" style="font-size: 12px;width:100%" readonly="">
   </td>
   <td>
      <select class="form-control bom_make" name="bom_make[]">
        <?php echo $value['make_opt'];  ?>
      </select>
   </td>
   <td>
      <select class="form-control bom_model" name="bom_model[]">
         <?php echo $value['model_opt'];  ?>
      </select>
      <!-- <input type="text" class="form-control " name="bom_model[]" value="NS1406" placeholder="Model" style="font-size: 12px;width:100%" readonly> -->
   </td>
   <td>
      <input type="text" class="form-control  po-avilable-stock" name="bom_po_stock[]" value="<?php echo $value['bom_po_stock'];  ?>" placeholder="Available Qty" style="font-size: 12px;width:100%" readonly="">
   </td>
   <td>
      <input type="text" class="form-control  js-requires-dc-qty" name="bom_dc_stock[]" value="<?php echo $value['dc_qty'];  ?>" placeholder="Required Qty" style="font-size: 12px;width:100%">
   </td>
   <td>
      <input type="text" class="form-control" name="bom_good_condition[]" value="<?php echo $value['good_condition_qty'];  ?>" placeholder="Good Condition Qty" style="font-size: 12px;width:100%">
   </td>
   <td>
      <input type="text" class="form-control" name="bom_bad_condition[]" value="<?php echo $value['bad_condition_qty'];  ?>" placeholder="Bad Condition Qty" style="font-size: 12px;width:100%" readonly="">
   </td>
   <td class="hide">
      <input type="text" class="form-control  js-po-basic_rate " name="rate_basic[]" value="<?php echo $value['veriable_rate'];  ?>" placeholder="Required Qty" style="font-size: 12px;width:100%">
      <input type="hidden" class="form-control  basic_rate " name="basic_rate[]" value="<?php echo $value['rate_basic'];  ?>" placeholder="Required Qty" style="font-size: 12px;width:100%">
   </td>
   <td class="hide">
      <input type="text" class="form-control " name="bom_gst[]" value="<?php echo $value['bom_gst'];  ?>" placeholder="Required gst" style="font-size: 12px;width:100%" readonly="">
   </td>
   <td class="hide">
      <input type="text" class="form-control " name="amount[]" value="<?php echo $value['amount'];  ?>" placeholder="Required Qty" style="font-size: 12px;width:100%" readonly="">
   </td>
</tr>

	<?php }
?>
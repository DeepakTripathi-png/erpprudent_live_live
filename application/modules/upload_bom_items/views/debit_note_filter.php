
                      <?php
                      // pr($data);
                      if (count($data) > 0) {
                       
                        foreach ($data as $key => $value) {  ?>
                        	<tr>
                            <td><?php echo $key + 1 ?></td>
                            <td><?php echo !empty($value['bp_code']) ? $value['bp_code'] : '-' ?></td>
                            <td><?php echo !empty($value['po_number']) ? $value['po_number'] : '-' ?></td>
                            <td><?php echo !empty($value['vdc_number']) ? $value['vdc_number'] : '-' ?></td>
                            <td><?php echo !empty($value['total_amount']) ? number_format($value['total_amount'],2,".","") : '0.00' ?></td>
                            <td><?php echo !empty($value['advance_payment']) ? number_format($value['advance_payment'],2,".","") : '0.00' ?></td>
                            
                            <td>
                            <a class=" openview" href="javascript:void(0);" data-project_id="<?php echo base64_encode($value['project_id']); ?>" data-boq_code="" data-type="<?php echo $type; ?>" data-status="" data-id="<?php echo $value['vdc_number']; ?>" style="margin-right: 8px;">VIEW</a></td>

                          </tr>
                        <?php }
                      }else{?>
                          <!-- <tr class="text-center" colspan="13"> No data Found </tr> -->
                        <?php	}
                        ?>
                      
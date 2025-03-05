$( document ).ready(function() {
    

    var payout_selection_data = $('#payout_selection_data').DataTable({
        ajax: {
            url: "bank_payment_data", // Controller endpoint
            type: "POST",
        },
        columns: [
           
            { data: 'bp_code' },
            { data: 'payout_number' },
            { data: 'vendor_name' },
            // { data: 'bank_name' },
            { data: 'beneficiary_bank' },
            { data: 'vendor_account_no' },
            { data: 'ifsc_code' },
            { data: 'ifsc_code' },
            // { data: 'po_number' },
            // { data: 'grn_number' },
            { data: 'total_amount' },
            { data: 'account_no' },
            { data: 'payment_date' },
            { data: 'utr_no' },
            // { data: 'status' },
            { data: 'action', orderable: false, searchable: false }
        ],
        columnDefs: [
            { targets: "_all", className: "text-center align-middle" }
        ],
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        lengthMenu: [10, 25, 50],
        dom: 'Bfrtip', 
        buttons: [
            'copy', 
            'excel', 
            {
                extend: 'pdf',
                title: 'Payout', 
                orientation: 'landscape', 
                pageSize: 'A4', 
            },
            'print', 
            'colvis', 
        ],
    });

    $(document).on("click", ".add-utr-number", function () {
        var payoutSelectionId = $(this).data("payout-selection-id"); // Get data attribute
    
        Swal.fire({
            title: "Add UTR Number",
            html: `
                <input type="text" id="utr_number" class="swal2-input" placeholder="Enter UTR Number">
                <select id="payment_mode" class="swal2-select">
                    <option value="">Select Payment Mode</option>
                    <option value="NFT">NFT</option>
                    <option value="RMG">RMG</option>
                    <option value="IMF">IMF</option>
                    <option value="PMT">PMT</option>
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: "Save",
            preConfirm: () => {
                var utrNumber = $("#utr_number").val().trim();
                var paymentMode = $("#payment_mode").val();
    
                if (utrNumber === "" || paymentMode === "") {
                    Swal.showValidationMessage("Both fields are required!");
                    return false;
                }
    
                return { utrNumber, paymentMode }; // Return input values
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "add_utr_no_in_payout_selection", // Backend PHP file
                    type: "POST",
                    data: {
                        payout_selection_id: payoutSelectionId,
                        utr_number: result.value.utrNumber,
                        payment_mode: result.value.paymentMode
                    },
                    success: function (response) {
                        try {
                            var res = JSON.parse(response); // Ensure response is parsed as JSON
                            
                            if (res.success) {
                                Swal.fire("Success!", "UTR Number saved successfully!", "success").then(() => {
                                    location.reload(); 
                                });
                            } else {
                                Swal.fire("Error!", res.message || "Failed to save UTR Number!", "error");
                            }
                        } catch (e) {
                            Swal.fire("Error!", "Invalid response from server!", "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Error!", "Something went wrong!", "error");
                    }
                    
                });
            }
        });
    });
    


    $(document).on("click", ".download-bank-payment", function () {
        var payoutId = $(this).attr("data-payout-selection-id"); // Get ID from button
        console.log("Payout ID:", payoutId); // Debugging
    
        $.ajax({
            url: base_url + 'get_bank_payment_data_for_excel', // Replace with your API URL
            type: 'POST',
            dataType: 'json',
            data: { payout_id: payoutId }, // Send ID to backend
            success: function (response) {
                console.log(response);
                
                // if (!response || !response.data || response.data.length === 0) {
                //     alert("No data found for this payout!");
                //     return;
                // }
    
                generateExcel(response.data, payoutId);
            },
            error: function () {
                alert("Error fetching data!");
            }
        });
    });


    });


    function generateExcel(data, payoutId) {
        console.log(data);
        
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Bank Payment');
    
       
        const titleRow = worksheet.addRow(['Bank Payment Report']);
        worksheet.mergeCells('A1:K1'); // Merge Columns A to K
        titleRow.font = { bold: true, size: 14 };
        titleRow.alignment = { horizontal: 'center', vertical: 'middle' };
    
       
        worksheet.addRow([]);
    
       
        const headers = [
            "Sr. No.", "BP Code", "Payout Number", "Vendor Name", "Beneficiary Bank", 
            "Vendor Account No", "IFSC Code", "Total Amount", "Account No", 
            "Payment Date", "UTR Number"
        ];
    
        const headerRow = worksheet.addRow(headers);
        headerRow.font = { bold: true };
    
     
        headerRow.eachCell((cell) => {
            cell.border = {
                top: { style: 'thin' },
                left: { style: 'thin' },
                bottom: { style: 'thin' },
                right: { style: 'thin' }
            };
            cell.alignment = { horizontal: 'center', vertical: 'middle' };
        });
    
       
        data.forEach((item, index) => {
            const row = worksheet.addRow([
                index + 1,
                item.bp_code || 'N/A',               
                item.payout_number || 'N/A',         
                item.vendor_name || 'N/A',           
                item.beneficiary_bank || 'N/A',      
                item.vendor_account_no || 'N/A',     
                item.ifsc_code || 'N/A',             
                parseFloat(item.total_amount) || 0,  
                item.account_no || 'N/A',            
                item.payment_date || 'N/A',          
                item.utr_no && item.utr_no !== '-' ? item.utr_no : 'N/A' 
            ]);
    
           
            row.eachCell((cell) => {
                cell.border = {
                    top: { style: 'thin' },
                    left: { style: 'thin' },
                    bottom: { style: 'thin' },
                    right: { style: 'thin' }
                };
                cell.alignment = { horizontal: 'center', vertical: 'middle' };
            });
        });
    
       
        worksheet.columns.forEach((column, index) => {
            if (index == 8) {  
                column.width = 50;  
            } else {
                column.width = 20;  
            }
        });
        
    
        // Export Excel File
        workbook.xlsx.writeBuffer().then((buffer) => {
            const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            saveAs(blob, `Bank_Payment_${payoutId}.xlsx`);
        });
    }
    
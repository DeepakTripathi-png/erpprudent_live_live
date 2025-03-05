$( document ).ready(function() {
    

    var payout_selection_data = $('#payout_selection_data').DataTable({
        ajax: {
            url: "get_payout_selection_data_list", // Controller endpoint
            type: "POST",
        },
        columns: [
           
            { data: 'bp_code' },
            { data: 'payout_number' },
            { data: 'po_number' },
            { data: 'grn_number' },
            { data: 'total_amount' },
            { data: 'account_no' },
            { data: 'payment_date' },
            // { data: 'status' },
            // { data: 'action', orderable: false, searchable: false }
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


var payout_list = $('#payout_selection_list').DataTable({
    ajax: {
        url: "get_payout_selction_list", // Controller endpoint
        type: "POST",
    },
    columns: [
        { data: 'selection' },
        { data: 'bp_code' },
        { data: 'payout_number' },
        { data: 'po_number' },
        { data: 'settled_amount' },
        { data: 'payment_date' },
        { data: 'status' },
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


// payout_list.on('draw', function () {
//     setTimeout(function () {
//         let poData = getUniquePONumbersAndTotalAmounts()  
//         $.each(poData, function(poNumber, totalAmount) {
           
//             let poHtml = `
//                 <p>
//                     <span style="margin-right:100px">PO Number: <b>${poNumber}</b></span>
//                     Total Amount: <span><b>${totalAmount}</b></span>
//                 </p>
//             `;
//             $(".po_info").append(poHtml);
//         });
//     }, 1000);  
// });


  setTimeout(function () {
        let poData = getUniquePONumbersAndTotalAmounts()  
        $.each(poData, function(poNumber, totalAmount) {
           
            let poHtml = `
                <p>
                    <span style="margin-right:100px">PO Number: <b>${poNumber}</b></span>
                    Total Amount: <span><b>${totalAmount}</b></span>
                </p>
            `;
            $(".po_info").append(poHtml);
        });
    }, 1000); 
$('#payout_selection_list tbody').on('click', '.openview', function () {
    // Toggle button text between "CLOSE" and "VIEW"
    $(this).text(function (i, text) {
        return text === "CLOSE" ? "VIEW" : "CLOSE";
    });

    // Extract data attributes
    const payout_id = $(this).attr('data-payout-id');
    const payout_item_id = $(this).attr('data-payout-item-id');
    const tr = $(this).closest('tr');
    
    if (typeof payout_list === "undefined") {
        console.error("payout_list DataTable is not defined!");
        return;
    }

    const row = payout_list.row(tr);

    if (row.child.isShown()) {
        row.child.hide();
        tr.removeClass('shown');
    } else {
        const divwidth = $("#bomtranslist").width();
        const divminwidth = divwidth - 20;

        let filterhtml = '';
        const download_title = 'Payout Details';

        const html = `
            <div class="portlet-body form" id="displayed${payout_id}">
                <div class="displayFlx" style="margin-bottom: 15px; display: flex;">
                    ${filterhtml}
                </div>
                <div id="originalpbomviewdiv${payout_id}">
                    <div class="table-responsive">
                        <table width="100%" id="originalpbomview${payout_id}" class="table table-striped table-bordered table-hover" style="text-align: left;">
                            <thead style="background: #26a69a; color: #fff; font-weight: 400;">
                                <tr>
                                    <th scope="col" style="vertical-align: top;">Sr.no</th>
                                    <th scope="col" style="vertical-align: top;">GRN No</th>
                                    <th scope="col" style="vertical-align: top;">GRN Amount</th>
                                    <th scope="col" style="vertical-align: top;">Settled Amount</th>
                                    <th scope="col" style="vertical-align: top;">Balance Amount</th>
                                    <th scope="col" style="vertical-align: top;">Status</th>
                                    <th scope="col" style="vertical-align: top;">Percentage (%)</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;

        row.child(html).show();
        tr.addClass('shown');

        // Initialize DataTable
        const table2 = $(`#originalpbomview${payout_id}`).DataTable({
            dom: 'Bfrtip',
            scrollY: 400,
            scrollX: true,
            scroller: true,
            fixedHeader: {
                header: true,
                footer: true,
            },
            ajax: {
                url: `${base_url}payout_list_display`,
                type: "POST",
                data: { payout_id: payout_id,payout_item_id:payout_item_id },
                error: function (xhr, error, thrown) {
                    console.error("Error fetching data:", error, thrown);
                },
            },
            lengthMenu: [
                [25, 50, 75, 100, 125, 150, -1],
                ['25 rows', '50 rows', '75 rows', '100 rows', '125 rows', '150 rows', 'Show all'],
            ],
            buttons: [
                'pageLength',
                { extend: 'copy', title: download_title, footer: true },
                {
                    extend: 'excel',
                    title: download_title,
                    footer: true,
                    customize: function (xlsx) {
                        const sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row c[r^="C"]', sheet).attr('s', '55');
                    },
                },
                { extend: 'pdf', title: download_title, footer: true },
                { extend: 'print', title: download_title, footer: true },
            ],
            autoWidth: false,
            destroy: true,
            paging: true,
            displayLength: 25,
            deferRender: true,
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
            columnDefs: [
                { targets: [0], orderable: false },
                { targets: [3, 4, 5, 6], className: "text-right" },
            ],
        });

        new $.fn.dataTable.FixedHeader(table2);
    }
});


// $(".bank-payment").click(function (e) {
//     e.preventDefault(); 
    
//     var selectedAccount = $("#account_number").val();
//     var checkedBoxes = $("input[name='payout_selection']:checked").length;

//     if (selectedAccount === "") {
//         // alert("Please select an account number.");
//         $(".alert-container").removeClass("hide");
//         $(".alert-container").html('<div class="alert modify alert-danger">Please select an account number.</div>');
//         setTimeout(function() {
//             $(".alert-container").addClass("hide");
//         },3000);
//         return;
//     }

//     if (checkedBoxes === 0) {
//         // alert("Please select at least one payout.");
//         $(".alert-container").removeClass("hide");
//         $(".alert-container").html('<div class="alert modify alert-danger">Please select at least one payout.</div>');
//         setTimeout(function() {
//             $(".alert-container").addClass("hide");
//         },3000);
//         return;
//     }

//     alert("Form submitted successfully!");
//     // Here, you can proceed with form submission (e.g., AJAX request)
// });


$(".bank-payment").click(function (e) {
    e.preventDefault(); 
    
    var selectedAccount = $("#account_number").val();
    var selectedPayouts = [];

    $("input[name='payout_selection[]']:checked").each(function() {
        selectedPayouts.push($(this).attr("payout-id"));
    });
    // console.log(selectedPayouts);
    // console.log(selectedPayouts.length);
    
    if (selectedAccount === "") {
        $(".alert-container").removeClass("hide");
        $(".alert-container").html('<div class="alert modify alert-danger">Please select an account number.</div>');
        setTimeout(function() {
            $(".alert-container").addClass("hide");
        }, 3000);
        return;
    }

    if (selectedPayouts.length === 0) {
        $(".alert-container").removeClass("hide");
        $(".alert-container").html('<div class="alert modify alert-danger">Please select at least one payout.</div>');
        setTimeout(function() {
            $(".alert-container").addClass("hide");
        }, 3000);
        return;
    }

    $.ajax({
        url: "save_payout_selection",  
        type: "POST",
        data: {
            account_number: selectedAccount,
            payout_ids: selectedPayouts
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                $(".alert-container").removeClass("hide");
                $(".alert-container").html('<div class="alert modify alert-success">' + response.message + '</div>');
            } else {
                $(".alert-container").removeClass("hide");
                $(".alert-container").html('<div class="alert modify alert-danger">' + response.message + '</div>');
            }
            setTimeout(function() {
                $(".alert-container").addClass("hide");
                location.reload();
            }, 3000);
        },
        error: function(xhr, status, error) {
            console.log("AJAX Error: " + error);
        }
    });
});



});

function getUniquePONumbersAndTotalAmounts() {
    let poData = {};

    // Loop through each row in the table body
    $("#payout_selection_list tbody tr").each(function () {
        // Get PO number from the 3rd column (index 2)
        let poNumber = $(this).find("td:eq(3)").text().trim(); 
        // console.log("PO Number:", poNumber); // Debugging PO Number

        // Get amount from the 5th column (index 4)
        let amountText = $(this).find("td:eq(4)").text().trim(); 
        let amount = parseFloat(amountText) || 0; // Parse the amount as float
        // console.log("Amount Text:", amountText); // Debugging the raw text of amount
        // console.log("Amount Parsed:", amount); // Debugging parsed amount

        // Check if both PO number and amount are valid
        if (poNumber && amount) {
            if (poData[poNumber]) {
                // If PO number already exists, add the amount to the existing total
                poData[poNumber] += amount;
            } else {
                // If PO number doesn't exist, create a new entry with the amount
                poData[poNumber] = amount;
            }
        }
    });

    // console.log("Final PO Data:", poData); // Final result with PO numbers and their total amounts
    return poData;
}








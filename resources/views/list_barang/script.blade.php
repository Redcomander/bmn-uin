<script>
    function printQR(button) {
        var barcode = button.getAttribute('data-barcode');
        var nama_barang = button.getAttribute('data-nama');
        var posisi = button.getAttribute('data-posisi');
        var merk = button.getAttribute('data-merk');

        // Generate the QR code URL using Laravel-QrCode
        @if (!$inventory->isEmpty())
            var qrCodeUrl = `{!! QrCode::size(400)->generate($col->barcode) !!}`;
        @else
            var qrCodeUrl = ''; // Set to an empty string or a default value when there's no data
        @endif


        // Create a new window or tab
        var printWindow = window.open('', '_blank');

        // Generate the HTML content for the QR code
        var qrCodeHtml = `
    <html>
    <head>
        <title>QR Code Print</title>
    </head>
    <body>
        <div class="text-center" style="text-align: center; font-size: 50px; margin-top: 50%;">
            <img src="${qrCodeUrl}
        </div>
        <div style="text-align: center; font-size: 50px; margin-top: 20px;">
            ${nama_barang}
        </div>
        <div style="text-align: center; font-size: 50px; margin-top: 20px;">
            ${posisi}
        </div>
        <div style="text-align: center; font-size: 50px; margin-top: 20px;">
            ${merk}
        </div>
    </body>
    </html>
`;

        // Set the content of the new window/tab
        printWindow.document.open();
        printWindow.document.write(qrCodeHtml);
        printWindow.document.close();

        // Print the QR code
        printWindow.print();

        // Close the new window/tab after printing
        printWindow.close();
    }
</script>
<script>
    $(document).ready(function() {


        $('#master').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $(".sub_chk").prop('checked', true);
            } else {
                $(".sub_chk").prop('checked', false);
            }
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });


            if (allVals.length <= 0) {
                alert("Please select row.");
            } else {


                var check = confirm("Are you sure you want to delete this row?");
                if (check == true) {


                    var join_selected_values = allVals.join(",");


                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: 'ids=' + join_selected_values,
                        success: function(data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                                location.reload();
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function(data) {
                            alert(data.responseText);
                        }
                    });


                    $.each(allVals, function(index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function(event, element) {
                element.trigger('confirm');
            }
        });


        $(document).on('confirm', function(e) {
            var ele = e.target;
            e.preventDefault();


            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                        location.reload();
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function(data) {
                    alert(data.responseText);
                }
            });
            return false;
        });
    });
    const checkboxes = $('.sub_chk');
    const actionButtonsContainer = $('#action-buttons');
    const masterCheckbox = $('#master');

    // Function to update visibility and count
    function updateVisibilityAndCount() {
        // Check if at least one checkbox is checked
        const checkedCheckboxes = checkboxes.filter(':checked');
        const numberOfCheckedItems = checkedCheckboxes.length;

        // Check the state of the table head checkbox
        const isMasterChecked = masterCheckbox.is(':checked');

        // Change the visibility property of the action buttons
        if (numberOfCheckedItems > 0 || isMasterChecked) {
            actionButtonsContainer.css('visibility', 'visible');
        } else {
            actionButtonsContainer.css('visibility', 'hidden');
        }

        // Update the counter text
        $('#selected-item-count').text(numberOfCheckedItems + ' item selected');
    }

    // Initialize visibility and count
    updateVisibilityAndCount();

    // Handle checkbox click events
    checkboxes.on('change', function() {
        updateVisibilityAndCount();
    });

    // Handle table head checkbox click event
    masterCheckbox.on('change', function() {
        checkboxes.prop('checked', this.checked);
        updateVisibilityAndCount();
    });
</script>
<script>
    // Function to populate filtering dropdowns with unique values from the dataset
    function populateFilterDropdowns() {
        var dropdowns = document.querySelectorAll('.filter-dropdown');

        dropdowns.forEach(function(dropdown) {
            var columnIndex = dropdown.getAttribute('data-column-index');
            var uniqueValues = [];
            var table = document.getElementById('inventory-table');
            var tr = table.getElementsByTagName('tr');

            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName('td')[columnIndex];

                if (td) {
                    var txtValue = td.textContent || td.innerText;
                    if (!uniqueValues.includes(txtValue)) {
                        uniqueValues.push(txtValue);
                    }
                }
            }

            var select = document.getElementById(dropdown.id);

            uniqueValues.forEach(function(value) {
                var option = document.createElement('option');
                option.value = value;
                option.text = value;
                select.appendChild(option);
            });
        });
    }

    // Attach the populateFilterDropdowns function to the 'DOMContentLoaded' event
    document.addEventListener('DOMContentLoaded', populateFilterDropdowns);

    // Attach the filterTableByColumn function to the change event of each dropdown
    var filterDropdowns = document.querySelectorAll('.filter-dropdown');
    filterDropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('change', filterTableByColumn);
    });

    // Function to filter the table based on the selected column and value
    function filterTableByColumn() {
        var dropdown = this;
        var columnIndex = dropdown.getAttribute('data-column-index');
        var filterValue = dropdown.value.toUpperCase();
        var table = document.getElementById('inventory-table');
        var tr = table.getElementsByTagName('tr');

        for (var i = 1; i < tr.length; i++) {
            var td = tr[i].getElementsByTagName('td')[columnIndex];

            if (td) {
                var txtValue = td.textContent || td.innerText;
                if (filterValue === '' || txtValue.toUpperCase().indexOf(filterValue) > -1) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    }
</script>

<script>
    function filterTable() {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("inventory-table");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            var shouldDisplay = false; // Flag to determine if the row should be displayed

            // Loop through the columns you want to search (e.g., column 2 and column 3)
            for (j = 1; j <= 3; j++) {
                td = tr[i].getElementsByTagName("td")[j]; // Adjust the indices to match the columns you want to search
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        shouldDisplay = true;
                        break; // Break the loop when a match is found in any column
                    }
                }
            }

            // Display or hide the row based on the 'shouldDisplay' flag
            if (shouldDisplay) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    // Attach the filterTable function to the input field's input event
    document.getElementById("searchInput").addEventListener("input", filterTable);
</script>

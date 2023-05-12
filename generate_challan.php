<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract the form data
    $form_data = array(
        'date' => $_POST['date'],
        'number' => $_POST['invoice_number'],
        'from' => $_POST['from'],
        'from_address' => $_POST['from_address'],
        'to' => $_POST['to'],
        'ship_to' => $_POST['ship_to'],
        'name' => $_POST['item_name'],
        'unit_cost' => $_POST['unit_cost'],
        'quantity' => $_POST['quantity'],
        'logo' => $_POST['logo'],
        'currency' => $_POST['currency'],
        'due_date' => $_POST['due_date'],
        'tax' => $_POST['tax'],
        'amount_paid' => $_POST['amount_paid'],
        'notes' => $_POST['notes']
    );

    // Generate the API URL with the form data as query parameters
    $api_endpoint = 'https://anyapi.io/api/v1/invoice/generate?' . http_build_query($form_data);

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $api_endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        // Assuming the API returns the generated invoice as a PDF
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="invoice.pdf"');
        echo $response;
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice Generator</title>
</head>
<body>
    <h1>Invoice Generator</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="date">Date:</label>
        <input type="text" name="date" id="date" required><br><br>
        
        <label for="invoice_number">Invoice Number:</label>
        <input type="text" name="invoice_number" id="invoice_number" required><br><br>
        
        <label for="from">From:</label>
        <input type="text" name="from" id="from" required><br><br>
        
        <label for="from_address">From Address:</label>
        <input type="text" name="from_address" id="from_address" required><br><br>
        
        <label for="to">To:</label>
        <input type="text" name="to" id="to" required><br><br>
        
        <label for="ship_to">Ship To:</label>
        <input type="text" name="ship_to" id="ship_to" required><br><br>
        
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" id="item_name" required><br><br>
        
        <label for="unit_cost">Unit Cost:</label>
        <input type="number" name="unit_cost" id="unit_cost" required><br><br>
        
        <label for="quantity">Quantity:</label>
        <input type="number         name="quantity" id="quantity" required><br><br>
        
        <label for="logo">Logo URL:</label>
        <input type="text" name="logo" id="logo"><br><br>
        
        <label for="currency">Currency:</label>
        <input type="text" name="currency" id="currency" required><br><br>
        
        <label for="due_date">Due Date:</label>
        <input type="text" name="due_date" id="due_date" required><br><br>
        
        <label for="tax">Tax:</label>
        <input type="number" name="tax" id="tax"><br><br>
        
        <label for="amount_paid">Amount Paid:</label>
        <input type="number" name="amount_paid" id="amount_paid"><br><br>
        
        <label for="notes">Notes:</label>
        <textarea name="notes" id="notes"></textarea><br><br>
        
        <button type="submit">Generate Invoice</button>
    </form>
</body>
</html>


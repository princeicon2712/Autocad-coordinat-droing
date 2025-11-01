<?php
$response = ''; // To hold the server response

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect OTP input values from the form
    $otp1 = $_POST['otp1'] ?? '';
    $otp2 = $_POST['otp2'] ?? '';
    $otp3 = $_POST['otp3'] ?? '';
    $otp4 = $_POST['otp4'] ?? '';

    // Validate input (basic check)
    if (is_numeric($otp1) && is_numeric($otp2) && is_numeric($otp3) && is_numeric($otp4)) {
        // Construct the target URL with OTP digits
        $url = "https://fsmms.dgf.gov.bd/farmers/bn/verify-otp?"
             . "otp1=$otp1&otp2=$otp2&otp3=$otp3&otp4=$otp4";

        // Set HTTP headers
        $headers = [
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Language: en-US,en;q=0.5",
            "Referer: https://fsmms.dgf.gov.bd/farmers/bn/register",
            "Cookie: JSESSIONID=402BD571E78DABB71DFCCD7669DBBCB0"
        ];

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute and store response
        $response = curl_exec($ch);

        // Handle cURL errors
        if (curl_errno($ch)) {
            $response = 'Request Error: ' . curl_error($ch);
        }

        curl_close($ch);
    } else {
        $response = 'Invalid OTP digits. Please enter numbers only.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        input[type="text"] {
            width: 40px;
            font-size: 20px;
            text-align: center;
            margin: 0 5px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
        }
        .response {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #ccc;
            white-space: pre-wrap;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<h2>Enter 4-Digit OTP</h2>
<form method="POST">
    <input type="text" name="otp1" maxlength="1" required>
    <input type="text" name="otp2" maxlength="1" required>
    <input type="text" name="otp3" maxlength="1" required>
    <input type="text" name="otp4" maxlength="1" required>
    <br><br>
    <button type="submit">Submit OTP</button>
</form>

<?php if (!empty($response)): ?>
    <div class="response">
        <strong>Server Response:</strong><br>
        <?php echo htmlspecialchars($response); ?>
    </div>
<?php endif; ?>

</body>
</html>
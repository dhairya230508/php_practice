<?php
function calculateTotalBill($itemPrice, $quantity, $day, $paymentMode, $shoppingTime, $membershipStatus, $carryBagRequired, $distinctItems) {

    $totalBill = $itemPrice * $quantity;


    if ($day === 'wednesday') {
        $totalBill *= 0.90;
    }

    
    if ($totalBill > 3000) {
        $totalBill *= 0.93;
    }

    
    if ($distinctItems >= 5) {
        $totalBill *= 0.95;
    }
    
    if ($paymentMode === 'upi') {
        $totalBill *= 0.95;
    } elseif ($paymentMode === 'online') {
        $totalBill *= 0.97;
    }

    if ($shoppingTime === 'morning') {
        $totalBill *= 0.98;
    }

    
    if ($membershipStatus === 'member') {
        $totalBill *= 0.95;
    }

    
    if ($carryBagRequired === 'yes') {
        $totalBill += 10;
    }

    return round($totalBill, 2);
}

$errors = [];
$result = false;

if (isset($_POST['submit'])) {

    $itemPrice = $_POST['itemPrice'];
    $quantity = $_POST['quantity'];
    $day = $_POST['day'];
    $paymentMode = $_POST['paymentMode'];
    $shoppingTime = $_POST['shoppingTime'];
    $membershipStatus = $_POST['membershipStatus'];
    $carryBagRequired = $_POST['carryBagRequired'];
    $distinctItems = $_POST['distinctItems'];

    if ($itemPrice <= 0) $errors[] = "Item price must be greater than 0";
    if ($quantity <= 0) $errors[] = "Quantity must be greater than 0";
    if ($distinctItems <= 0) $errors[] = "Distinct items must be greater than 0";

    if (empty($errors)) {
        $totalBill = calculateTotalBill(
            $itemPrice,
            $quantity,
            $day,
            $paymentMode,
            $shoppingTime,
            $membershipStatus,
            $carryBagRequired,
            $distinctItems
        );
        $result = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Billing System</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

form {
    width: 400px;
    margin: 30px auto;
    padding: 40px;
    background-color: #fff;
    border: 1px solid #ccc;
}

label {
    margin-top: 8px;
    font-weight: bold;
    display: block;
}

input, select {
    width: 100%;
    padding: 5px;
    margin-top: 4px;
}

.submit-btn {
    width: 100%;
    margin-top: 15px;
    padding: 8px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}


.submit-btn {
    margin-top: 15px;
    padding: 6px 14px;
    background: #4CAF50;
    color: #fff;
    border: 1px solid #4CAF50;
    cursor: pointer;
}

.submit-btn:hover {
    background: #45a049;
}


.error {
    width: 320px;
    margin: 10px auto;
    color: red;
    text-align: center;
}

table {
    width: 50%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: white;
}

th, td {
    border: 1px solid #ccc;
    padding: 8px;
}

th {
    background-color: #f0f0f0;
}
</style>

</head>

<body>

<form method="post">
    <label>Item Price</label>
    <input type="number" name="itemPrice" required>

    <label>Quantity</label>
    <input type="number" name="quantity" required>

    <label>Day of Shopping</label>
    <select name="day">
        <option>monday</option>
        <option>tuesday</option>
        <option>wednesday</option>
        <option>thursday</option>
        <option>friday</option>
        <option>saturday</option>
        <option>sunday</option>
    </select>

    <label>Payment Mode</label>
    <select name="paymentMode">
        <option>upi</option>
        <option>online</option>
        <option>cash</option>
    </select>

    <label>Shopping Time</label>
    <select name="shoppingTime">
        <option>morning</option>
        <option>evening</option>
    </select>

    <label>Membership Status</label>
    <select name="membershipStatus">
        <option>member</option>
        <option>non-member</option>
    </select>

    <label>Carry Bag Required</label>
    <select name="carryBagRequired">
        <option>yes</option>
        <option>no</option>
    </select>

    <label>Distinct Items</label>
    <input type="number" name="distinctItems" required>

    <input type="submit" class="submit-btn" value="Calculate Bill">

</form>

<?php if (!empty($errors)) { ?>
    <div class="error">
        <?php foreach ($errors as $e) echo $e . "<br>"; ?>
    </div>
<?php } ?>

<?php if ($result) { ?>
<table>
    <tr><th>Item Price</th><td><?= $itemPrice ?></td></tr>
    <tr><th>Quantity</th><td><?= $quantity ?></td></tr>
    <tr><th>Day</th><td><?= ucfirst($day) ?></td></tr>
    <tr><th>Payment Mode</th><td><?= strtoupper($paymentMode) ?></td></tr>
    <tr><th>Shopping Time</th><td><?= ucfirst($shoppingTime) ?></td></tr>
    <tr><th>Membership</th><td><?= ucfirst($membershipStatus) ?></td></tr>
    <tr><th>Carry Bag</th><td><?= ucfirst($carryBagRequired) ?></td></tr>
    <tr><th>Distinct Items</th><td><?= $distinctItems ?></td></tr>
    <tr><th><b>Total Bill</b></th><td><b>₹ <?= $totalBill ?></b></td></tr>
</table>
<?php } ?>

</body>
</html>

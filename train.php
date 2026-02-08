<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Train Ticket Booking</title>

    <style>
    body {


        font-family: Arial;
        background: #f2f2f2;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    form {
        background: white;
        padding: 20px;
        width: 350px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input,
    select,
    button {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    button {
        background: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background: #0056b3;
    }

    .msg {
        margin-top: 10px;
        padding: 8px;
        background: #eee;
        border: 1px solid #ccc;
    }
    </style>

</head>

<body>

    <form method="post">
        <input type="text" name="pname" placeholder="Passenger Name" required>
        <input type="number" name="page" placeholder="Age">
        <input type="number" name="dis" placeholder="Distance (km)">

        <select name="clas">
            <option value="">Select Class</option>
            <option value="SL">SL</option>
            <option value="3AC">3AC</option>
            <option value="2AC">2AC</option>
            <option value="1AC">1AC</option>
        </select>

        <select name="pay">
            <option value="">Payment Mode</option>
            <option value="UPI">UPI</option>
            <option value="Cash">Cash</option>
            <option value="Other">Other</option>
        </select>

        <input type="number" name="ticket" placeholder="Number of Tickets">

        <button type="submit" name="submit">BOOK</button>

        <?php
if (isset($_POST['submit'])) {

    $pname  = $_POST['pname'];
    $age    = $_POST['page'];
    $dis    = $_POST['dis'];
    $clas   = $_POST['clas'];
    $pay    = $_POST['pay'];
    $ticket = $_POST['ticket'];

    /* Simple Validation */
    if ($age <= 0 || $dis <= 0 || $ticket <= 0) {
        echo "<div class='msg'>Please enter valid values.</div>";
        exit;
    }

    /* Fare Calculation */
    $fare = 10 * $dis;

    if ($age <= 12) $fare *= 0.5;
    elseif ($age <= 16) $fare *= 0.6;

    if ($dis >= 500) $fare *= 0.9;
    elseif ($dis > 100) $fare *= 0.95;

    if ($clas == "1AC") $fare *= 1.4;
    elseif ($clas == "2AC") $fare *= 1.3;
    elseif ($clas == "3AC") $fare *= 1.2;

    if ($pay == "UPI") $fare *= 0.9;
    elseif ($pay == "Other") $fare *= 0.95;

    if ($ticket >= 5) $fare *= 0.9;

    $total = round($fare * $ticket, 2);

    /* Display All Details */
    echo "<div class='msg'>
            <b>Booking Details</b><br><br>
            Passenger Name : $pname <br>
            Age : $age <br>
            Distance : $dis km <br>
            Class : $clas <br>
            Payment Mode : $pay <br>
            Number of Tickets : $ticket <br>
            <b>Total Fare : ₹ $total</b>
          </div>";
}
?>

    </form>

</body>

</html>
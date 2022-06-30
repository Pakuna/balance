<?php require "core/balance.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    <link rel="shortcut icon" href="src/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="src/style.css">
    <script defer src="balance.js"></script>
</head>
<body>
    <input id="search" autocomplete="off" autofocus>
    <select id="filter">
        <option selected>All</option>
    </select>
    <table>
        <thead>
            <tr>
                <td>Date</td>
                <td>Memo</td>
                <td>Amount</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach(getTransactions() as $oTransaction) include "tpl/entry.php"; ?>
        </tbody>
    </table>
    <div id="stats"></div>
    <div id="chart"></div>
</body>
</html>
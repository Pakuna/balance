<?php

require "transaction.php";

$sFileName = "data.csv";

// Checking for new data.csv file
if (!file_exists($sFileName)) return;

$rCsv = fopen($sFileName, "r");
$sHeader = fgetcsv($rCsv, 120); // First line is the header

// Loop through the rest of the file to get all transactions
$aImport = []; $sImportTimeStamp = date("Y-m-d H:i:s");
while (($aLine = fgetcsv($rCsv, 120)) !== false) {
    if (count($aLine) < 2) continue; // Empty line
    list($sNumber, $sDate, $sAccount, $sAmount, $sSubCat, $sMemo) = array_map("trim", $aLine);
    $oTransaction = new Transaction($sDate, $sMemo, $sAmount);
    $oTransaction->assignCategory($aConfig["matching"]);
    $oTransaction->imported = $sImportTimeStamp;
    $aImport[] = $oTransaction;
}
fclose($rCsv);

// remove($sFileName);
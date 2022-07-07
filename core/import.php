<?php

$sFileName = $aConfig["import_file"];

// Checking for new data.csv file
if (!file_exists($sFileName)) return;

$rCsv = fopen($sFileName, "r");
$sHeader = fgetcsv($rCsv, 120); // First line is the header

// Loop through the rest of the file to get all transactions
$aImport = [];
while (($aLine = fgetcsv($rCsv, 120)) !== false) {
    if (count($aLine) < 2) continue; // Empty line
    list($sNumber, $sDate, $sAccount, $sAmount, $sSubCat, $sMemo) = array_map("trim", $aLine);
    $oTransaction = new Transaction($sDate, $sMemo, $sAmount);
    $oTransaction->new = true;
    $aImport[] = $oTransaction;
}
fclose($rCsv);

remove($sFileName);

// Remove transactions we already stored
$aImport = array_filter($aImport, function($oTransaction) {
    global $aTransactions;
    foreach (array_reverse($aTransactions, true) as $oCheckTransaction) {
        if ($oCheckTransaction->new) continue;
        if ($oCheckTransaction->hash != $oTransaction->hash) continue;
        return false;
    }
    return true;
});

// Store new transactions to DB
if (!empty($aImport)) {
    $aTransactions = array_merge($aTransactions, $aImport);
    echo count($aTransactions);

    uasort($aTransactions, function($oT1, $oT2) {
        return $oT2->date <=> $oT1->date;
    });
    file_put_contents("db/transactions.json", json_encode(array_values($aTransactions)));
}
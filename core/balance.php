<?php

require "config.php";

// Read transactions from DB
$aTransactions = [];
$aJson = json_decode(@file_get_contents("db/transactions.json"), true) ?? [];

// Run import
require "import.php";

// Store new transactions to DB
if (!empty($aImport)) {
    //var_dump(array_diff_assoc($aImport, array_unique($aImport))); die;
    //$aTransactions = array_merge($aTransactions, $aImport);
    $aTransactions = array_unique(array_merge($aTransactions, $aImport));
    uasort($aTransactions, function($oT1, $oT2) {
        return $oT2->date <=> $oT1->date;
    });
    file_put_contents("db/transactions.json", json_encode(array_values($aTransactions)));
}

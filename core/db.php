<?php

function readFromCache() : array {
    $sCacheFile = getCacheFileName();
    return readFromJsonFile($sCacheFile);
}

function readFromDatabase() : array {
    $aTransactions = readFromJsonFile("db/transactions.json", true);

    // Store to cache
    $sCacheFile = getCacheFileName();
    file_put_contents($sCacheFile, json_encode(array_values($aTransactions)));

    return $aTransactions;
}

// Reads array of transactions from given file
// Optional: Assigns each transation category
function readFromJsonFile(string $sFile, ?bool $bAssignCategories = false) : array {
    global $aConfig;
    $aTransactions = [];
    $aJson = json_decode(@file_get_contents($sFile), true) ?? [];
    foreach ($aJson as $aLine) {
        list($sHash, $sDate, $sMemo, $sAmount, $sCategory) = $aLine;
        $oTransaction = new Transaction($sDate, $sMemo, $sAmount, $sCategory);
        $oTransaction->new = false;
        if ($bAssignCategories) $oTransaction->assignCategory($aConfig["matching"]);
        $aTransactions[] = $oTransaction;
    }
    return $aTransactions;
}

function getCacheFileName() : string {
    global $aConfig;
    $sCatHash = md5(serialize($aConfig["categories"]));
    $sCacheFile = "db/cache.{$sCatHash}.json";
    return $sCacheFile;
}

$aTransactions = readFromCache();
if (empty($aTransactions)) {
    $aTransactions = readFromDatabase();
}
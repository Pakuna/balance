<?php

$aConfig = [
    // Where to read new transactions from
    "import_file" => "data.csv",

    // List of categories/sub-categories and their search terms to match transactions
    "categories" => [
        "Income" => [
            "Lea"           => ["204115", "patasic"],
            "Stefan"        => ["1/hahn", "stefan"],

            // No need for terms as all other positive transactions are assigned here
            "Other"         => [],
        ],
        "Utilities" => [
            "Internet"      => ["vodafone"],
            "Water"         => ["south staffs"],
            "City Council"  => ["cambridge city"],
            "Energy"        => ["utility", "shell energy", "e.on"],
            "Rent"          => ["bidwells"],
            "HelloFresh"    => ["hellofresh"]
        ],
        "Supermarkets" => [
            "Co-op"         => ["co-op"],
            "Sainsbury's"   => ["sainsbury"],
            "M&S"           => ["marks&spencer", "m&s"],
            "Waitrose"      => ["waitrose"],
            "Boots"         => ["boots"],
            "TKMaxx"        => ["maxx"],
            "Tesco"         => ["tesco"],
            "Wilko"         => ["wilko"],
        ],
        "Camb Market" => [
            "camcattle", "brownbread", "garden kitchen",
            "borough olives", "fen tomato", "sharky and george"
        ],
        "Nursery"           => ["harvey road"],
        "Ryanair"           => ["ryanair"],
        "Trainline"         => ["trainline"],
        "Amazon"            => ["amazo", "amzn"],
        "Greater Anglia"    => ["greater"]
    ]

];

// Flattens list of categories and sub-categories down to one level
foreach ($aConfig["categories"] as $sCategory => $aSearch) {
    // Check if sub-categories are defined
    if (count(array_filter(array_keys($aSearch), "is_string")) > 0) {
        foreach ($aSearch as $sSubCat => $aTerms) {
            $sKey = $sCategory . "_" . $sSubCat;
            $aConfig["matching"][$sKey] = $aTerms;
        }
    }
    else {
        $aConfig["matching"][$sCategory] = $aSearch;
    }
}
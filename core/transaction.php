<?php

class Transaction implements JsonSerializable {

    public function __construct(string $sDate, string $sMemo, string $sAmount) {
        // Unique hash to identify duplicates
        $this->hash = md5($sDate . $sMemo . $sAmount);
        $this->date = $this->formatDate($sDate);
        $this->memo = $sMemo;
        $this->amount = (float) $sAmount;
    }

    // Analyses memo to assign specific category
    public function assignCategory(array $aCategories) {
        $this->category = "";
        foreach ($aCategories as $sCategory => $aTerms) {
            foreach ($aTerms as $sTerm) {
                if (stripos($this->memo, $sTerm) !== false) $this->category = $sCategory;
            }
        }
    }

    // Used to store this transaction to JSON DB
    public function jsonSerialize() {
        return array_values(get_object_vars($this));
    }

    public function __toString() : string {
        return $this->hash;
    }

    // Formates 13/05/2022 > 2022-05-13
    private function formatDate(string $sDate) : string {
        list($sDay, $sMonth, $sYear) = explode("/", $sDate);
        return "{$sYear}-{$sMonth}-{$sDay}";
    }
}
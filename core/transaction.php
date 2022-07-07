<?php

class Transaction implements JsonSerializable {

    public function __construct(string $sDate, string $sMemo, string $sAmount, ?string $sCategory = "") {
        $this->date = $this->formatDate($sDate);
        $this->memo = $sMemo;
        $this->amount = (float) $sAmount;
        $this->category = $sCategory;

        // Unique hash to identify duplicates
        $this->hash = md5($this->date . $this->memo . $this->amount);
    }

    // Analyses memo to assign specific category
    public function assignCategory(array $aCategories) {
        foreach ($aCategories as $sCategory => $aTerms) {
            foreach ($aTerms as $sTerm) {
                if (stripos($this->memo, $sTerm) !== false) $this->category = $sCategory;
            }
        }
    }

    // Used to store this transaction to JSON DB
    public function jsonSerialize() {
        return [
            $this->hash,
            $this->date,
            $this->memo,
            $this->amount,
            $this->category
        ];
    }

    // Formates 13/05/2022 > 2022-05-13
    private function formatDate(string $sDate) : string {
        // Date already formated?
        if (strpos($sDate, "/") === false) return $sDate;

        list($sDay, $sMonth, $sYear) = explode("/", $sDate);
        return "{$sYear}-{$sMonth}-{$sDay}";
    }
}
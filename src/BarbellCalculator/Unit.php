<?php
/**
 * Created by PhpStorm.
 * User: garethellis
 * Date: 23/02/15
 * Time: 11:41.
 */

namespace Gumbercules\BarbellCalculator;


trait Unit
{
    protected $validUnits = [
        "kg" => 2.5,
        "lb" => 5,
    ];

    public function isValidUnit($unit)
    {
        return in_array($unit, array_keys($this->validUnits));
    }
}

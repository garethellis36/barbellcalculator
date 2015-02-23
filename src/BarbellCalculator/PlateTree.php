<?php
/**
 * Created by PhpStorm.
 * User: garethellis
 * Date: 23/02/15
 * Time: 11:56.
 */

namespace Gumbercules\BarbellCalculator;

class PlateTree
{
    use Unit;

    protected $plates = [
        [
            "kg" => 25,
            "lb" => 55,
            "multi" => true,
            "color" => "red",
            "size" => "large",
        ],
        [
            "kg" => 20,
            "lb" => 45,
            "multi" => true,
            "color" => "blue",
            "size" => "large",
        ],
        [
            "kg" => 15,
            "lb" => 35,
            "multi" => false,
            "color" => "yellow",
            "size" => "large",
        ],
        [
            "kg" => 10,
            "lb" => 25,
            "multi" => false,
            "color" => "green",
            "size" => "small",
        ],
        [
            "kg" => 5,
            "lb" => 10,
            "multi" => false,
            "color" => "orange",
            "size" => "small",
        ],
        [
            "kg" => 2.5,
            "lb" => 5,
            "multi" => false,
            "color" => "red",
            "size" => "small",
        ],
        [
            "kg" => 1.25,
            "lb" => 2.5,
            "multi" => false,
            "color" => "blue",
            "size" => "small",
        ],
    ];

    protected $includeBigRedPlates = false;

    protected $unit;

    public function __construct($unit, $include_big_red_plates = false)
    {
        if (! $this->isValidUnit($unit)) {
            throw new \Gumbercules\Exception\InvalidUnitException($unit." is not a valid unit of weight");
        }

        $this->unit = $unit;
        $this->includeBigRedPlates = $include_big_red_plates;
    }

    public function getPlates()
    {
        foreach ($this->plates as $k => $plate) {
            $this->plates[$k]['weight'] = $plate[$this->unit];
            if (!$this->includeBigRedPlates && $this->isABigRedPlate($plate)) {
                unset($this->plates[$k]);
            }
        }

        return $this->plates;
    }

    protected function isABigRedPlate($plate)
    {
        return ($plate["color"] == "red" && $plate["size"] == "large");
    }
}

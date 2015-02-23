<?php
/**
 * Created by PhpStorm.
 * User: garethellis
 * Date: 23/02/15
 * Time: 11:40.
 */

namespace Gumbercules\BarbellCalculator;

class Barbell
{
    use Unit;

    protected $plates = [];

    protected $unit;

    protected $barWeight;

    protected $defaultWeights = [
        "kg" => 20,
        "lb" => 45,
    ];

    protected $totalWeight;

    protected $collarWeight = 0;

    public function __construct($unit, $barWeight = null, $collarWeight = 0)
    {
        if (! $this->isValidUnit($unit)) {
            throw new \Gumbercules\Exception\InvalidUnitException($unit." is not a valid unit of weight");
        }

        $this->unit = $unit;

        $barWeight = ($barWeight ? $barWeight : $this->defaultWeights[$this->unit]);

        $this->setBarWeight($barWeight);

        $this->setCollarWeight($collarWeight);

        $this->setTotalWeight($barWeight + $collarWeight);
    }

    protected function setCollarWeight($collarWeight)
    {
        $this->collarWeight = $collarWeight;

        return true;
    }

    public function getCollarWeight()
    {
        return $this->collarWeight;
    }

    protected function setBarWeight($barWeight)
    {
        $this->barWeight = $barWeight;

        return true;
    }

    public function getBarWeight()
    {
        return $this->barWeight;
    }

    public function loadPlate(array $plate)
    {
        $this->plates[] = [
            "weight" => $plate["weight"],
            "color" => $plate["color"],
            "size" => $plate["size"]
        ];

        return $this->setTotalWeight($this->getTotalWeight() + $plate["weight"]);
    }

    public function getPlates()
    {
        return $this->plates;
    }

    protected function setTotalWeight($weight)
    {
        $this->totalWeight = $weight;

        return true;
    }

    public function getTotalWeight()
    {
        return $this->totalWeight;
    }
}

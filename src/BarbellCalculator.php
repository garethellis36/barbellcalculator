<?php
/**
 * Platform is a simple PHP library for calculating the plates to be loaded onto a weightlifting barbell.
 */

namespace Gumbercules;

use Gumbercules\BarbellCalculator\Barbell;
use Gumbercules\BarbellCalculator\PlateTree;
use Gumbercules\Exception\BarTooHeavyException;
use Gumbercules\Exception\InvalidWeightException;

class BarbellCalculator
{
    use BarbellCalculator\Unit;

    protected $defaultOptions = [
        "include_big_red_plates"    => false,
        "bar_weight"                => null,
        "collar_weight"             => 0,
    ];

    protected $barbell;

    protected $plateTree;

    protected $targetWeight;

    protected $platesAdded = [];

    public function __construct($unit, $targetWeight, $options = array())
    {
        if (! $this->isValidUnit($unit)) {
            throw new \Gumbercules\Exception\InvalidUnitException($unit." is not a valid unit of weight");
        }

        $options = array_merge($this->defaultOptions, $options);

        if (!$this->isValidWeight($unit, $targetWeight, $options["collar_weight"])) {
            throw new \Gumbercules\Exception\InvalidWeightException("Please provide a weight divisible by ".$this->validUnits[$unit]);
        }

        $this->targetWeight = $targetWeight;

        $this->barbell = new Barbell($unit, $options["bar_weight"], $options["collar_weight"]);

        if ($this->barbell->getTotalWeight() > $targetWeight) {
            throw new \Gumbercules\Exception\BarTooHeavyException();
        }

        //get array of plate options
        $tree = new PlateTree($unit, $options["include_big_red_plates"]);
        $this->plateTree = $tree->getPlates();
    }

    public function calculate()
    {
        $this->selectPlates();

        return $this->barbell->getPlates();
    }

    protected function isValidWeight($unit, $targetWeight, $collarWeight)
    {
        return (fmod($targetWeight, $this->validUnits[$unit]) == 0 && fmod($collarWeight, $this->validUnits[$unit]) == 0);
    }

    protected function selectPlates()
    {
        foreach ($this->plateTree as $plate) {
            $balance = $this->calculateBalance();
            if ($balance == 0) {
                break;
            }

            if (!$plate["multi"] && in_array($plate["weight"], $this->platesAdded)) {
                continue;
            }

            while ($this->plateWeightLessThanBalance($plate)) {
                $this->barbell->loadPlate($plate);
                //we have to load each side of the bar
                $this->barbell->loadPlate($plate);
                $this->platesAdded[] = $plate["weight"];
            }
        }
    }

    protected function plateWeightLessThanBalance($plate)
    {
        $balance = $this->calculateBalance();

        return ($plate["weight"] * 2 <= $balance);
    }

    protected function calculateBalance()
    {
        return $this->targetWeight - $this->barbell->getTotalWeight();
    }
}

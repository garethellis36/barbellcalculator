<?php
/**
 * Created by PhpStorm.
 * User: garethellis
 * Date: 23/02/15
 * Time: 15:02.
 */

namespace Gumbercules\BarbellCalculator\test;

use Gumbercules\BarbellCalculator\PlateTree;

class PlateTreeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Gumbercules\Exception\InvalidUnitException
     */
    public function testInvalidUnitType()
    {
        $bbc = new PlateTree("invalid", 200);
    }

    public function testGetPlates()
    {
        $plates = [
            [
                "kg" => 20,
                "lb" => 45,
                "multi" => true,
                "color" => "blue",
                "size" => "large",
                "weight" => 20,
            ],
            [
                "kg" => 15,
                "lb" => 35,
                "multi" => false,
                "color" => "yellow",
                "size" => "large",
                "weight" => 15,
            ],
            [
                "kg" => 10,
                "lb" => 25,
                "multi" => false,
                "color" => "green",
                "size" => "small",
                "weight" => 10,
            ],
            [
                "kg" => 5,
                "lb" => 10,
                "multi" => false,
                "color" => "orange",
                "size" => "small",
                "weight" => 5,
            ],
            [
                "kg" => 2.5,
                "lb" => 5,
                "multi" => false,
                "color" => "red",
                "size" => "small",
                "weight" => 2.5,
            ],
            [
                "kg" => 1.25,
                "lb" => 2.5,
                "multi" => false,
                "color" => "blue",
                "size" => "small",
                "weight" => 1.25,
            ],
        ];

        $bigRedPlate = [
            "kg" => 25,
            "lb" => 55,
            "multi" => true,
            "color" => "red",
            "size" => "large",
            "weight" => 25,
        ];

        $tree = new PlateTree("kg");
        $this->assertEquals(array_values($plates), array_values($tree->getPlates()));

        array_unshift($plates, $bigRedPlate);
        $tree = new PlateTree("kg", true);
        $this->assertEquals(array_values($plates), array_values($tree->getPlates()));
    }
}

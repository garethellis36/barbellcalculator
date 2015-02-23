<?php
/**
 * Created by PhpStorm.
 * User: garethellis
 * Date: 23/02/15
 * Time: 15:02.
 */

namespace Gumbercules\BarbellCalculator\test;

use Gumbercules\BarbellCalculator\Barbell;

class BarbellTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Gumbercules\Exception\InvalidUnitException
     */
    public function testInvalidUnitType()
    {
        $bbc = new Barbell("invalid", 200);
    }

    public function testBarWeights()
    {

        //kgs default
        $bar = new Barbell("kg");
        $this->assertEquals(20, $bar->getBarWeight());

        //lbs default
        $bar = new Barbell("lb");
        $this->assertEquals(45, $bar->getBarWeight());

        //set manually
        $trapBarWeight = 35;
        $trapBar = new Barbell("kg", $trapBarWeight);
        $this->assertEquals($trapBarWeight, $trapBar->getBarWeight());
    }

    public function testTotalWeight()
    {
        //test manual with collars
        $safetyBarWeight = 25;
        $collarWeight = 5;
        $safetyBar = new Barbell("kg", $safetyBarWeight, $collarWeight);
        $this->assertEquals($safetyBarWeight + $collarWeight, $safetyBar->getTotalWeight());
    }

    public function testLoadPlates()
    {
        $plates = [
            [
                "weight" => 20,
                "color" => "blue",
                "size" => "large",
            ],
            [
                "weight" => 20,
                "color" => "blue",
                "size" => "large",
            ],
        ];

        $bar = new Barbell("kg");

        $this->assertEquals(20, $bar->getTotalWeight());
        foreach ($plates as $plate) {
            $this->assertTrue($bar->loadPlate($plate));
        }

        //test total bar weight
        $this->assertEquals(60, $bar->getTotalWeight());
    }

    public function testGetPlates()
    {
        //empty bar
        $bar = new Barbell("kg");
        $this->assertEquals([], $bar->getPlates());
    }
}

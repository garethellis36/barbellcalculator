<?php
namespace Gumbercules\BarbellCalculator\test;

use Gumbercules\BarbellCalculator;

class BarbellCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public $validUnits = ["kg", "lb"];

    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function testValidUnitType()
    {
        foreach ($this->validUnits as $unit) {
            $bbc = new BarbellCalculator($unit, 200);
            $this->assertTrue($bbc->isValidUnit($unit));
        }
    }

    /**
     * @expectedException Gumbercules\Exception\InvalidUnitException
     */
    public function testInvalidUnitType()
    {
        $bbc = new BarbellCalculator("invalid", 200);
    }

    public function testCalculator()
    {

        //test with no options using KG
        $calculator = new BarbellCalculator("kg", 120);
        $platesRequired = $calculator->calculate();

        $expected = [
            ["weight" => 20, "color" => "blue"],
            ["weight" => 20, "color" => "blue"],
            ["weight" => 20, "color" => "blue"],
            ["weight" => 20, "color" => "blue"],
            ["weight" => 10, "color" => "green"],
            ["weight" => 10, "color" => "green"],
        ];
        $actual = [];

        foreach ($platesRequired as $k => $plate) {
            $actual[] = ["weight" => $plate["weight"], "color" => $plate["color"]];
        }
        $this->assertEquals($actual, $expected);

        //test with no options using LBs
        $calculator = new BarbellCalculator("lb", 200);
        $platesRequired = $calculator->calculate();

        $expected = [
            ["weight" => 45, "color" => "blue"],
            ["weight" => 45, "color" => "blue"],
            ["weight" => 25, "color" => "green"],
            ["weight" => 25, "color" => "green"],
            ["weight" => 5, "color" => "red"],
            ["weight" => 5, "color" => "red"],
            ["weight" => 2.5, "color" => "blue"],
            ["weight" => 2.5, "color" => "blue"],
        ];
        $actual = [];

        foreach ($platesRequired as $k => $plate) {
            $actual[] = ["weight" => $plate["weight"], "color" => $plate["color"]];
        }

        $this->assertEquals($actual, $expected);

        //test with non-standard bar weight
        $options = [
            "include_big_red_plates" => false,
            "bar_weight" => 35,
            "collar_weight" => 0,
        ];
        $calculator = new BarbellCalculator("kg", 160, $options);
        $platesRequired = $calculator->calculate();

        $expected = [
            ["weight" => 20, "color" => "blue"],
            ["weight" => 20, "color" => "blue"],
            ["weight" => 20, "color" => "blue"],
            ["weight" => 20, "color" => "blue"],
            ["weight" => 20, "color" => "blue"],
            ["weight" => 20, "color" => "blue"],
            ["weight" => 2.5, "color" => "red"],
            ["weight" => 2.5, "color" => "red"],
        ];
        $actual = [];

        foreach ($platesRequired as $k => $plate) {
            $actual[] = ["weight" => $plate["weight"], "color" => $plate["color"]];
        }
        $this->assertEquals($actual, $expected);

        //test including big red plates (25kg)
        $options = [
            "include_big_red_plates" => true,
            "bar_weight" => 20,
            "collar_weight" => 0,
        ];
        $calculator = new BarbellCalculator("kg", 180, $options);
        $platesRequired = $calculator->calculate();

        $expected = [
            ["weight" => 25, "color" => "red"],
            ["weight" => 25, "color" => "red"],
            ["weight" => 25, "color" => "red"],
            ["weight" => 25, "color" => "red"],
            ["weight" => 25, "color" => "red"],
            ["weight" => 25, "color" => "red"],
            ["weight" => 5, "color" => "orange"],
            ["weight" => 5, "color" => "orange"],
        ];
        $actual = [];

        foreach ($platesRequired as $k => $plate) {
            $actual[] = ["weight" => $plate["weight"], "color" => $plate["color"]];
        }
        $this->assertEquals($actual, $expected);

        //test including collars
        $options = [
            "collar_weight" => 5,
        ];
        $calculator = new BarbellCalculator("lb", 410, $options);
        $platesRequired = $calculator->calculate();

        $expected = [
            ["weight" => 45, "color" => "blue"],
            ["weight" => 45, "color" => "blue"],
            ["weight" => 45, "color" => "blue"],
            ["weight" => 45, "color" => "blue"],
            ["weight" => 45, "color" => "blue"],
            ["weight" => 45, "color" => "blue"],
            ["weight" => 45, "color" => "blue"],
            ["weight" => 45, "color" => "blue"],
        ];
        $actual = [];

        foreach ($platesRequired as $k => $plate) {
            $actual[] = ["weight" => $plate["weight"], "color" => $plate["color"]];
        }
        $this->assertEquals($actual, $expected);
    }

    /**
     * @expectedException Gumbercules\Exception\InvalidWeightException
     */
    public function testInvalidWeight()
    {
        $bbc = new BarbellCalculator("kg", 46);
    }

    /**
     * @expectedException Gumbercules\Exception\BarTooHeavyException
     */
    public function testBarTooHeavy()
    {
        $bbc = new BarbellCalculator("kg", 15);
    }
}

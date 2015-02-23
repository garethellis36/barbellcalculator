# barbellcalculator
Simple PHP lib for calculating the plates required to load a barbell

If you're into any kind of barbell weightlifting, be it Olympic lifting, powerlifting or just "getting swole" then you've no doubt had to do tricky mental sums to work out what plates you need loaded on the bar in order to attempt lifting a certain weight.  

This library attempts to address this problem.

## Install with composer:
```
composer require gumbercules/barbellcalculator
```

## Usage:
Import the class namespace:
```
use Gumbercules\BarbellCalculator
```

Instantiate a new calculator:
```
$barbellCalculator = new BarbellCalculator("kg", 180);
```
Arguments to this constructor call:
```
@param string $unit: "kg" or "lb" depending on what unit you prefer
@param int/float $targetWeight: the amount of weight you want lifted on the bar (NB must be divisble by 2.5 for KGs or 5 for LBs)
@param optional array $options: define an options array for non-standard stuff:
- include_big_red_plates: set to true to include 25kg/55lb plates in the calculation
- bar_weight: set this to any numeric value in case you're dealing with a non-standard bar (defaults to 20kg/45lbs)
- collar_weight: set this if you're using competition collars (typically weigh 2.5kg each) - this value should be the _COMBINED_ weight of both collars
```

Calculate what plates are required:
```
$platesRequired = $barbellCalculator->calculate();
```

This will return an array with the weight, size and colour of plates you will need to load.


### TODO

* Add doc-blocks to code to document API properly
* Add options for micro-plates (e.g. 0.5kg, 1kg, etc)
* Consider setting upper limit on target weight for bar


### Contact
Catch me on Twitter @garethellis
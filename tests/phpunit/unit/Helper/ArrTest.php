<?php

namespace Bolt\Tests\Helper;

use Bolt\Helpers\Arr;
use Bolt\Tests\BoltUnitTest;

/**
 * Class to test src/Helper/Arr.
 *
 * @author Ross Riley <riley.ross@gmail.com>
 * @author Carson Full <carsonfull@gmail.com>
 */
class ArrTest extends BoltUnitTest
{
    /**
     * @group legacy
     */
    public function testMakeValuePairs()
    {
        $test = [
            ['id' => 1, 'value' => 1],
            ['id' => 2, 'value' => 2],
        ];
        $this->assertEquals([1 => 1, 2 => 2], Arr::makeValuePairs($test, 'id', 'value'));
        $this->assertEquals([0 => 1, 1 => 2], Arr::makeValuePairs($test, '', 'value'));
    }

    /**
     * @group legacy
     */
    public function testMergeRecursiveDistinct()
    {
        $arr1 = ['key' => 'orig value'];
        $arr2 = ['key' => 'new value'];
        $this->assertEquals(['key' => 'new value'], Arr::mergeRecursiveDistinct($arr1, $arr2));

        // Needs an exclusion for accept_file_types
        $arr1 = ['accept_file_types' => ['jpg']];
        $arr2 = ['accept_file_types' => ['jpg', 'png']];
        $actual = Arr::mergeRecursiveDistinct($arr1, $arr2);
        $this->assertEquals(['accept_file_types' => ['jpg', 'png']], $actual);

        // Test Recursion
        $arr1 = ['key' => ['test' => 'new value']];
        $arr2 = ['key' => ['test' => 'nested new value']];

        $this->assertEquals(
            ['key' => ['test' => 'nested new value']],
            Arr::mergeRecursiveDistinct($arr1, $arr2)
        );

        // This is why this method is deprecated:
        $arr1 = ['key' => ['foo', 'bar']];
        $arr2 = ['key' => ['baz']];
        $actual = Arr::mergeRecursiveDistinct($arr1, $arr2);
        $this->assertEquals(['key' => ['baz', 'bar']], $actual);
    }
}

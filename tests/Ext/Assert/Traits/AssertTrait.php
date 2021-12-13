<?php

namespace Tests\Ext\Assert\Traits;

use PHPUnit\Framework\Assert;

trait AssertTrait
{
    /**
     * Asserts that the given fields are present in the given object.
     *
     * @since UT (3.7.0)
     * @since 5.9.0 Added the `$message` parameter.
     *
     * @param object $object  The object to check.
     * @param array  $fields  The fields to check.
     * @param string $message Optional. Message to display when the assertion fails.
     */
    public static function assertEqualFields($object, $fields, $message = '')
    {
        Assert::assertIsObject($object, $message . ' Passed $object is not an object.');
        Assert::assertIsArray($fields, $message . ' Passed $fields is not an array.');
        Assert::assertNotEmpty($fields, $message . ' Fields array is empty.');

        foreach ($fields as $field_name => $field_value) {
            Assert::assertObjectHasAttribute($field_name, $object, $message . " Property $field_name does not exist on the object.");
            Assert::assertSame($field_value, $object->$field_name, $message . " Value of property $field_name is not $field_value.");
        }
    }

    /**
     * Asserts that two values are equal, with whitespace differences discarded.
     *
     * @since UT (3.7.0)
     * @since 5.9.0 Added the `$message` parameter.
     *
     * @param mixed  $expected The expected value.
     * @param mixed  $actual   The actual value.
     * @param string $message  Optional. Message to display when the assertion fails.
     */
    public static function assertDiscardWhitespace($expected, $actual, $message = '')
    {
        if (is_string($expected)) {
            $expected = preg_replace('/\s*/', '', $expected);
        }

        if (is_string($actual)) {
            $actual = preg_replace('/\s*/', '', $actual);
        }

        Assert::assertEquals($expected, $actual, $message);
    }

    /**
     * Asserts that two values have the same type and value, with EOL differences discarded.
     *
     * @since 5.6.0
     * @since 5.8.0 Added support for nested arrays.
     * @since 5.9.0 Added the `$message` parameter.
     *
     * @param mixed  $expected The expected value.
     * @param mixed  $actual   The actual value.
     * @param string $message  Optional. Message to display when the assertion fails.
     */
    public static function assertSameIgnoreEOL($expected, $actual, $message = '')
    {
        if (null !== $expected) {
            $expected = map_deep(
                $expected,
                static function ($value) {
                    if (is_string($value)) {
                        return str_replace("\r\n", "\n", $value);
                    }

                    return $value;
                }
            );
        }

        if (null !== $actual) {
            $actual = map_deep(
                $actual,
                static function ($value) {
                    if (is_string($value)) {
                        return str_replace("\r\n", "\n", $value);
                    }

                    return $value;
                }
            );
        }

        Assert::assertSame($expected, $actual, $message);
    }

    /**
     * Asserts that two values are equal, with EOL differences discarded.
     *
     * @since 5.4.0
     * @since 5.6.0 Turned into an alias for `::assertSameIgnoreEOL()`.
     * @since 5.9.0 Added the `$message` parameter.
     *
     * @param mixed  $expected The expected value.
     * @param mixed  $actual   The actual value.
     * @param string $message  Optional. Message to display when the assertion fails.
     */
    public static function assertEqualsIgnoreEOL($expected, $actual, $message = '')
    {
        static::assertSameIgnoreEOL($expected, $actual, $message);
    }

    /**
     * Asserts that the contents of two un-keyed, single arrays are the same, without accounting for the order of elements.
     *
     * @since 5.6.0
     * @since 5.9.0 Added the `$message` parameter.
     *
     * @param array  $expected Expected array.
     * @param array  $actual   Array to check.
     * @param string $message  Optional. Message to display when the assertion fails.
     */
    public static function assertSameSets($expected, $actual, $message = '')
    {
        Assert::assertIsArray($expected, $message . ' Expected value must be an array.');
        Assert::assertIsArray($actual, $message . ' Value under test is not an array.');

        sort($expected);
        sort($actual);
        Assert::assertSame($expected, $actual, $message);
    }

    /**
     * Asserts that the contents of two un-keyed, single arrays are equal, without accounting for the order of elements.
     *
     * @since 3.5.0
     * @since 5.9.0 Added the `$message` parameter.
     *
     * @param array  $expected Expected array.
     * @param array  $actual   Array to check.
     * @param string $message  Optional. Message to display when the assertion fails.
     */
    public static function assertEqualSets($expected, $actual, $message = '')
    {
        Assert::assertIsArray($expected, $message . ' Expected value must be an array.');
        Assert::assertIsArray($actual, $message . ' Value under test is not an array.');

        sort($expected);
        sort($actual);
        Assert::assertEquals($expected, $actual, $message);
    }

    /**
     * Asserts that the contents of two keyed, single arrays are the same, without accounting for the order of elements.
     *
     * @since 5.6.0
     * @since 5.9.0 Added the `$message` parameter.
     *
     * @param array  $expected Expected array.
     * @param array  $actual   Array to check.
     * @param string $message  Optional. Message to display when the assertion fails.
     */
    public static function assertSameSetsWithIndex($expected, $actual, $message = '')
    {
        Assert::assertIsArray($expected, $message . ' Expected value must be an array.');
        Assert::assertIsArray($actual, $message . ' Value under test is not an array.');

        ksort($expected);
        ksort($actual);
        Assert::assertSame($expected, $actual, $message);
    }

    /**
     * Asserts that the contents of two keyed, single arrays are equal, without accounting for the order of elements.
     *
     * @since 4.1.0
     * @since 5.9.0 Added the `$message` parameter.
     *
     * @param array  $expected Expected array.
     * @param array  $actual   Array to check.
     * @param string $message  Optional. Message to display when the assertion fails.
     */
    public static function assertEqualSetsWithIndex($expected, $actual, $message = '')
    {
        Assert::assertIsArray($expected, $message . ' Expected value must be an array.');
        Assert::assertIsArray($actual, $message . ' Value under test is not an array.');

        ksort($expected);
        ksort($actual);
        Assert::assertEquals($expected, $actual, $message);
    }

    /**
     * Asserts that the given variable is a multidimensional array, and that all arrays are non-empty.
     *
     * @since 4.8.0
     * @since 5.9.0 Added the `$message` parameter.
     *
     * @param array  $array   Array to check.
     * @param string $message Optional. Message to display when the assertion fails.
     */
    public static function assertNonEmptyMultidimensionalArray($array, $message = '')
    {
        Assert::assertIsArray($array, $message . ' Value under test is not an array.');
        Assert::assertNotEmpty($array, $message . ' Array is empty.');

        foreach ($array as $sub_array) {
            Assert::assertIsArray($sub_array, $message . ' Subitem of the array is not an array.');
            Assert::assertNotEmpty($sub_array, $message . ' Subitem of the array is empty.');
        }
    }
}

<?php

namespace core\lib;

/**
 * Validator functionality class.
 */
abstract class Validator
{
    /**
     * Checks that request input contains excepted details.
     *
     * @param  array   $expected - Array of expected details.
     * @param  array   $input    - Array of request input details.
     * @return boolean
     */
    public function check(array $expected, array $input) : bool
    {
        foreach ($expected as $detail) {
            if (! \in_array($detail, \array_keys($input))) {
                return false;
            }
        }

        return true;
    }
}
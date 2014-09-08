<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Tests\Sources;

/**
 * Class SourceTest
 * A Test Source file to use with unit testing.
 * We are only concerned with 2 items from the trans and transChoice methods; The id and the domain.
 * These are used in the extraction process to be set in the catalogue.
 *
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class TestSource
{
    public function doStuffAction()
    {
        $test1 = $this->trans('test1');
        $test2 = $this->trans('test2', array('%s;' => '2'));
        $test3 = $this->trans('test3', array(), 'test');
        $test4 = $this->trans('test4', array(), 'test', 'en');
        $test5 = $this->trans('test5', array('%s;' => '5'), 'test', 'en');

        $test6 = $this->transChoice('test6', 6);
        $test7 = $this->transChoice('test7', 7, array('%s;' => '7'));
        $test8 = $this->transChoice('test8', 8, array(), 'test');
        $test9 = $this->transChoice('test9', 9, array(), 'test', 'en');
        $test10 = $this->transChoice('test10', 10, array('%s;' => '10'), 'test', 'en');
    }

    protected function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        return true;
    }

    protected function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        return true;
    }
}

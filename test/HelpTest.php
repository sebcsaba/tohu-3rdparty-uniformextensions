<?php

use ToHu\UniWrapper;

require_once __DIR__.'/fake_joomla.php';
require_once __DIR__.'/../src/set_limits.php';

class HelpTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldWork()
    {
        $scaffold = UniWrapper::scaffold(49);
//        echo $scaffold; return;
        ob_start();
        eval($scaffold);
        $result = ob_get_clean();
        echo $result;
    }
}

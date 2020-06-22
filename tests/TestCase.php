<?php

namespace Test;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        parent::setUp();
        load_test_env();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 02/10/2017
 * Time: 2:14 AM
 */

namespace Mxgel\MPesa\Tests;


/**
 * Class Test
 *
 * @package Mxgel\MPesa\Tests
 */
class Test
{
    /**
     * @var string
     */
    protected $test;

    /**
     * Test constructor.
     *
     * @param string $test
     */
    public function __construct(string $test)
    {
        $this->test = $test;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $contents = file_get_contents($this->getTestFileName());

        return json_decode($contents, true);
    }

    /**
     * @return string
     */
    protected function getTestFileName(): string
    {
        return __DIR__ . "/" . $this->test . ".json";
    }

    /**
     * @param string $test
     *
     * @return Test
     */
    public function setTest(string $test): Test
    {
        $this->test = $test;

        return $this;
    }
}
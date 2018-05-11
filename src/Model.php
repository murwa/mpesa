<?php
/**
 * Created by PhpStorm.
 * User: mxgel
 * Date: 30/09/2017
 * Time: 3:56 AM
 */

namespace Mxgel\MPesa;

use Mxgel\MPesa\Contracts\EndpointsContract;
use Mxgel\MPesa\Contracts\IdentifierContract;
use GuzzleHttp\Client;
use ReflectionProperty;

/**
 * Class Model
 *
 * @package Mxgel\MPesa
 */
abstract class Model implements EndpointsContract, IdentifierContract
{
    /**
     * @var array
     */
    protected $hidden = ['method'];

    /**
     * @var array
     */
    protected $only = [];

    /**
     * @var string
     */
    protected $dateFormat = 'YmdHis';

    /**
     * Model constructor.
     *
     * @param $content
     */
    public function __construct($content = null)
    {
        if (is_string($content)) {
            $this->createFromString($content);
        } else if (is_array($content)) {
            $this->createFromArray($content);
        }
    }

    /**
     * @param string $content
     *
     * @return \Mxgel\MPesa\Model
     */
    protected function createFromString($content)
    {
        return $this->createFromArray(json_decode($content, true));
    }

    /**
     * @param array $content
     *
     * @return \Mxgel\MPesa\Model
     */
    protected function createFromArray($content)
    {
        foreach ($content as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * Get http client for sending requests
     *
     * @param array $options
     *
     * @param bool $live
     *
     * @return \GuzzleHttp\Client
     */
    protected static function getHttpClient($options = [], $live = false)
    {
        return new Client(array_merge([
            'base_uri' => $live === 'live' ? self::LIVE_URL : self::SANDBOX_URL,
        ], $options));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        $hidden = array_merge($this->hidden, [
            'hidden',
            'only',
            'dateFormat',
        ]);
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PUBLIC);

        foreach ($props as $prop) {
            $name = $prop->getName();
            if (!in_array($name, $hidden) && (in_array($name, $this->only) || !count($this->only))) {
                $array[studly_case($name)] = $this->get($name);
            }
        }

        return $array;
    }

    /**
     * Get model's json representation
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * Model to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * Magic get
     *
     * @param $name
     *
     * @return mixed
     */
    public function get($name)
    {
        $name = camel_case($name);
        $method = camel_case("get_{$name}");
        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return $this->{$name};
    }

    /**
     * @param string $name
     * @param        $value
     *
     * @return \Mxgel\MPesa\Model
     */
    public function set($name, $value)
    {
        $name = camel_case($name);
        $method = camel_case("set_{$name}");
        if (method_exists($this, $method)) {
            $this->{$method}($value);
        } else {
            $this->{$name} = $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param array $hidden
     *
     * @return \Mxgel\MPesa\Model
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }
}
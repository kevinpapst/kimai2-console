<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Kimai 2 - API Docs
 *
 * JSON API for the Kimai 2 time-tracking software. Read more about its usage in the [API documentation](https://www.kimai.org/documentation/rest-api.html) and then download a [Swagger file](doc.json) for import e.g. in Postman. Be aware: it is not yet considered stable and BC breaks might happen, but we try to avoid them.
 *
 * OpenAPI spec version: 0.4
 *
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.10
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace KimaiConsole\Client\Model;

use ArrayAccess;
use KimaiConsole\Client\ObjectSerializer;

/**
 * I18nConfig Class Doc Comment
 *
 * @category Class
 * @author   Swagger Codegen team
 * @see     https://github.com/swagger-api/swagger-codegen
 */
class I18nConfig implements ModelInterface, ArrayAccess
{
    public const DISCRIMINATOR = null;

    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = 'I18nConfig';

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerTypes = [
        'form_date_time' => 'string',
        'form_date' => 'string',
        'date_time' => 'string',
        'date' => 'string',
        'time' => 'string',
        'duration' => 'string',
        'is24hours' => 'bool'
    ];

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerFormats = [
        'form_date_time' => null,
        'form_date' => null,
        'date_time' => null,
        'date' => null,
        'time' => null,
        'duration' => null,
        'is24hours' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'form_date_time' => 'formDateTime',
        'form_date' => 'formDate',
        'date_time' => 'dateTime',
        'date' => 'date',
        'time' => 'time',
        'duration' => 'duration',
        'is24hours' => 'is24hours'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'form_date_time' => 'setFormDateTime',
        'form_date' => 'setFormDate',
        'date_time' => 'setDateTime',
        'date' => 'setDate',
        'time' => 'setTime',
        'duration' => 'setDuration',
        'is24hours' => 'setIs24hours'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'form_date_time' => 'getFormDateTime',
        'form_date' => 'getFormDate',
        'date_time' => 'getDateTime',
        'date' => 'getDate',
        'time' => 'getTime',
        'duration' => 'getDuration',
        'is24hours' => 'getIs24hours'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['form_date_time'] = $data['form_date_time'] ?? null;
        $this->container['form_date'] = $data['form_date'] ?? null;
        $this->container['date_time'] = $data['date_time'] ?? null;
        $this->container['date'] = $data['date'] ?? null;
        $this->container['time'] = $data['time'] ?? null;
        $this->container['duration'] = $data['duration'] ?? null;
        $this->container['is24hours'] = $data['is24hours'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }

    /**
     * Gets form_date_time
     *
     * @return string
     */
    public function getFormDateTime()
    {
        return $this->container['form_date_time'];
    }

    /**
     * Sets form_date_time
     *
     * @param string $form_date_time form_date_time
     *
     * @return $this
     */
    public function setFormDateTime($form_date_time)
    {
        $this->container['form_date_time'] = $form_date_time;

        return $this;
    }

    /**
     * Gets form_date
     *
     * @return string
     */
    public function getFormDate()
    {
        return $this->container['form_date'];
    }

    /**
     * Sets form_date
     *
     * @param string $form_date form_date
     *
     * @return $this
     */
    public function setFormDate($form_date)
    {
        $this->container['form_date'] = $form_date;

        return $this;
    }

    /**
     * Gets date_time
     *
     * @return string
     */
    public function getDateTime()
    {
        return $this->container['date_time'];
    }

    /**
     * Sets date_time
     *
     * @param string $date_time date_time
     *
     * @return $this
     */
    public function setDateTime($date_time)
    {
        $this->container['date_time'] = $date_time;

        return $this;
    }

    /**
     * Gets date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->container['date'];
    }

    /**
     * Sets date
     *
     * @param string $date date
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->container['date'] = $date;

        return $this;
    }

    /**
     * Gets time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->container['time'];
    }

    /**
     * Sets time
     *
     * @param string $time time
     *
     * @return $this
     */
    public function setTime($time)
    {
        $this->container['time'] = $time;

        return $this;
    }

    /**
     * Gets duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->container['duration'];
    }

    /**
     * Sets duration
     *
     * @param string $duration duration
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->container['duration'] = $duration;

        return $this;
    }

    /**
     * Gets is24hours
     *
     * @return bool
     */
    public function getIs24hours()
    {
        return $this->container['is24hours'];
    }

    /**
     * Sets is24hours
     *
     * @param bool $is24hours is24hours
     *
     * @return $this
     */
    public function setIs24hours($is24hours)
    {
        $this->container['is24hours'] = $is24hours;

        return $this;
    }

    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param int $offset Offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param int $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int $offset Offset
     * @param mixed $value Value to be set
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param int $offset Offset
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
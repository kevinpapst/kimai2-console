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
 * ExpenseEditForm Class Doc Comment
 *
 * @category Class
 * @author   Swagger Codegen team
 * @see     https://github.com/swagger-api/swagger-codegen
 */
class ExpenseEditForm implements ModelInterface, ArrayAccess
{
    public const DISCRIMINATOR = null;

    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = 'ExpenseEditForm';

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerTypes = [
        'begin' => '\DateTime',
        'customer' => 'int',
        'project' => 'int',
        'activity' => 'int',
        'category' => 'string',
        'description' => 'string',
        'multiplier' => 'float',
        'refundable' => 'bool'
    ];

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerFormats = [
        'begin' => 'date-time',
        'customer' => null,
        'project' => null,
        'activity' => null,
        'category' => 'KimaiPlugin\ExpensesBundle\Entity\ExpenseCategory id',
        'description' => null,
        'multiplier' => null,
        'refundable' => null
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
        'begin' => 'begin',
        'customer' => 'customer',
        'project' => 'project',
        'activity' => 'activity',
        'category' => 'category',
        'description' => 'description',
        'multiplier' => 'multiplier',
        'refundable' => 'refundable'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'begin' => 'setBegin',
        'customer' => 'setCustomer',
        'project' => 'setProject',
        'activity' => 'setActivity',
        'category' => 'setCategory',
        'description' => 'setDescription',
        'multiplier' => 'setMultiplier',
        'refundable' => 'setRefundable'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'begin' => 'getBegin',
        'customer' => 'getCustomer',
        'project' => 'getProject',
        'activity' => 'getActivity',
        'category' => 'getCategory',
        'description' => 'getDescription',
        'multiplier' => 'getMultiplier',
        'refundable' => 'getRefundable'
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
        $this->container['begin'] = $data['begin'] ?? null;
        $this->container['customer'] = $data['customer'] ?? null;
        $this->container['project'] = $data['project'] ?? null;
        $this->container['activity'] = $data['activity'] ?? null;
        $this->container['category'] = $data['category'] ?? null;
        $this->container['description'] = $data['description'] ?? null;
        $this->container['multiplier'] = $data['multiplier'] ?? null;
        $this->container['refundable'] = $data['refundable'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['begin'] === null) {
            $invalidProperties[] = "'begin' can't be null";
        }
        if ($this->container['project'] === null) {
            $invalidProperties[] = "'project' can't be null";
        }
        if ($this->container['category'] === null) {
            $invalidProperties[] = "'category' can't be null";
        }
        if ($this->container['multiplier'] === null) {
            $invalidProperties[] = "'multiplier' can't be null";
        }

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
     * Gets begin
     *
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->container['begin'];
    }

    /**
     * Sets begin
     *
     * @param \DateTime $begin begin
     *
     * @return $this
     */
    public function setBegin($begin)
    {
        $this->container['begin'] = $begin;

        return $this;
    }

    /**
     * Gets customer
     *
     * @return int
     */
    public function getCustomer()
    {
        return $this->container['customer'];
    }

    /**
     * Sets customer
     *
     * @param int $customer Customer ID
     *
     * @return $this
     */
    public function setCustomer($customer)
    {
        $this->container['customer'] = $customer;

        return $this;
    }

    /**
     * Gets project
     *
     * @return int
     */
    public function getProject()
    {
        return $this->container['project'];
    }

    /**
     * Sets project
     *
     * @param int $project Project ID
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->container['project'] = $project;

        return $this;
    }

    /**
     * Gets activity
     *
     * @return int
     */
    public function getActivity()
    {
        return $this->container['activity'];
    }

    /**
     * Sets activity
     *
     * @param int $activity Activity ID
     *
     * @return $this
     */
    public function setActivity($activity)
    {
        $this->container['activity'] = $activity;

        return $this;
    }

    /**
     * Gets category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->container['category'];
    }

    /**
     * Sets category
     *
     * @param string $category category
     *
     * @return $this
     */
    public function setCategory($category)
    {
        $this->container['category'] = $category;

        return $this;
    }

    /**
     * Gets description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string $description description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets multiplier
     *
     * @return float
     */
    public function getMultiplier()
    {
        return $this->container['multiplier'];
    }

    /**
     * Sets multiplier
     *
     * @param float $multiplier multiplier
     *
     * @return $this
     */
    public function setMultiplier($multiplier)
    {
        $this->container['multiplier'] = $multiplier;

        return $this;
    }

    /**
     * Gets refundable
     *
     * @return bool
     */
    public function getRefundable()
    {
        return $this->container['refundable'];
    }

    /**
     * Sets refundable
     *
     * @param bool $refundable refundable
     *
     * @return $this
     */
    public function setRefundable($refundable)
    {
        $this->container['refundable'] = $refundable;

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

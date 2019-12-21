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
 * ExpenseSubCollection Class Doc Comment
 *
 * @category Class
 * @author   Swagger Codegen team
 * @see     https://github.com/swagger-api/swagger-codegen
 */
class ExpenseSubCollection implements ModelInterface, ArrayAccess
{
    public const DISCRIMINATOR = null;

    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = 'ExpenseSubCollection';

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerTypes = [
        'id' => 'int',
        'duration' => 'int',
        'activity' => '\KimaiConsole\Client\Model\Activity',
        'project' => '\KimaiConsole\Client\Model\Project',
        'category' => '\KimaiConsole\Client\Model\ExpenseCategory',
        'description' => 'string',
        'refundable' => 'bool',
        'total' => 'float',
        'begin' => '\DateTime',
        'end' => '\DateTime',
        'user' => 'int'
    ];

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerFormats = [
        'id' => null,
        'duration' => null,
        'activity' => null,
        'project' => null,
        'category' => null,
        'description' => null,
        'refundable' => null,
        'total' => 'float',
        'begin' => 'date-time',
        'end' => 'date-time',
        'user' => null
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
        'id' => 'id',
        'duration' => 'duration',
        'activity' => 'activity',
        'project' => 'project',
        'category' => 'category',
        'description' => 'description',
        'refundable' => 'refundable',
        'total' => 'total',
        'begin' => 'begin',
        'end' => 'end',
        'user' => 'user'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'duration' => 'setDuration',
        'activity' => 'setActivity',
        'project' => 'setProject',
        'category' => 'setCategory',
        'description' => 'setDescription',
        'refundable' => 'setRefundable',
        'total' => 'setTotal',
        'begin' => 'setBegin',
        'end' => 'setEnd',
        'user' => 'setUser'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'duration' => 'getDuration',
        'activity' => 'getActivity',
        'project' => 'getProject',
        'category' => 'getCategory',
        'description' => 'getDescription',
        'refundable' => 'getRefundable',
        'total' => 'getTotal',
        'begin' => 'getBegin',
        'end' => 'getEnd',
        'user' => 'getUser'
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
        $this->container['id'] = $data['id'] ?? null;
        $this->container['duration'] = $data['duration'] ?? null;
        $this->container['activity'] = $data['activity'] ?? null;
        $this->container['project'] = $data['project'] ?? null;
        $this->container['category'] = $data['category'] ?? null;
        $this->container['description'] = $data['description'] ?? null;
        $this->container['refundable'] = $data['refundable'] ?? null;
        $this->container['total'] = $data['total'] ?? null;
        $this->container['begin'] = $data['begin'] ?? null;
        $this->container['end'] = $data['end'] ?? null;
        $this->container['user'] = $data['user'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['project'] === null) {
            $invalidProperties[] = "'project' can't be null";
        }
        if ($this->container['category'] === null) {
            $invalidProperties[] = "'category' can't be null";
        }
        if ($this->container['refundable'] === null) {
            $invalidProperties[] = "'refundable' can't be null";
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
     * Gets id
     *
     * @return int
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param int $id id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->container['duration'];
    }

    /**
     * Sets duration
     *
     * @param int $duration duration
     *
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->container['duration'] = $duration;

        return $this;
    }

    /**
     * Gets activity
     *
     * @return \KimaiConsole\Client\Model\Activity2
     */
    public function getActivity()
    {
        return $this->container['activity'];
    }

    /**
     * Sets activity
     *
     * @param \KimaiConsole\Client\Model\Activity2 $activity activity
     *
     * @return $this
     */
    public function setActivity($activity)
    {
        $this->container['activity'] = $activity;

        return $this;
    }

    /**
     * Gets project
     *
     * @return \KimaiConsole\Client\Model\Project2
     */
    public function getProject()
    {
        return $this->container['project'];
    }

    /**
     * Sets project
     *
     * @param \KimaiConsole\Client\Model\Project2 $project project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->container['project'] = $project;

        return $this;
    }

    /**
     * Gets category
     *
     * @return \KimaiConsole\Client\Model\ExpenseCategory2
     */
    public function getCategory()
    {
        return $this->container['category'];
    }

    /**
     * Sets category
     *
     * @param \KimaiConsole\Client\Model\ExpenseCategory2 $category category
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
     * Gets total
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->container['total'];
    }

    /**
     * Sets total
     *
     * @param float $total total
     *
     * @return $this
     */
    public function setTotal($total)
    {
        $this->container['total'] = $total;

        return $this;
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
     * Gets end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->container['end'];
    }

    /**
     * Sets end
     *
     * @param \DateTime $end end
     *
     * @return $this
     */
    public function setEnd($end)
    {
        $this->container['end'] = $end;

        return $this;
    }

    /**
     * Gets user
     *
     * @return int
     */
    public function getUser()
    {
        return $this->container['user'];
    }

    /**
     * Sets user
     *
     * @param int $user user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->container['user'] = $user;

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

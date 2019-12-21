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
 * ActivityEntity Class Doc Comment
 *
 * @category Class
 * @author   Swagger Codegen team
 * @see     https://github.com/swagger-api/swagger-codegen
 */
class ActivityEntity implements ModelInterface, ArrayAccess
{
    public const DISCRIMINATOR = null;

    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = 'ActivityEntity';

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerTypes = [
        'id' => 'int',
        'name' => 'string',
        'comment' => 'string',
        'visible' => 'bool',
        'fixed_rate' => 'float',
        'hourly_rate' => 'float',
        'color' => 'string',
        'budget' => 'float',
        'time_budget' => 'int',
        'project' => 'int',
        'meta_fields' => '\KimaiConsole\Client\Model\ActivityMeta[]'
    ];

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerFormats = [
        'id' => null,
        'name' => null,
        'comment' => null,
        'visible' => null,
        'fixed_rate' => 'float',
        'hourly_rate' => 'float',
        'color' => null,
        'budget' => 'float',
        'time_budget' => null,
        'project' => null,
        'meta_fields' => null
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
        'name' => 'name',
        'comment' => 'comment',
        'visible' => 'visible',
        'fixed_rate' => 'fixedRate',
        'hourly_rate' => 'hourlyRate',
        'color' => 'color',
        'budget' => 'budget',
        'time_budget' => 'timeBudget',
        'project' => 'project',
        'meta_fields' => 'metaFields'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'name' => 'setName',
        'comment' => 'setComment',
        'visible' => 'setVisible',
        'fixed_rate' => 'setFixedRate',
        'hourly_rate' => 'setHourlyRate',
        'color' => 'setColor',
        'budget' => 'setBudget',
        'time_budget' => 'setTimeBudget',
        'project' => 'setProject',
        'meta_fields' => 'setMetaFields'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'name' => 'getName',
        'comment' => 'getComment',
        'visible' => 'getVisible',
        'fixed_rate' => 'getFixedRate',
        'hourly_rate' => 'getHourlyRate',
        'color' => 'getColor',
        'budget' => 'getBudget',
        'time_budget' => 'getTimeBudget',
        'project' => 'getProject',
        'meta_fields' => 'getMetaFields'
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
        $this->container['name'] = $data['name'] ?? null;
        $this->container['comment'] = $data['comment'] ?? null;
        $this->container['visible'] = $data['visible'] ?? null;
        $this->container['fixed_rate'] = $data['fixed_rate'] ?? null;
        $this->container['hourly_rate'] = $data['hourly_rate'] ?? null;
        $this->container['color'] = $data['color'] ?? null;
        $this->container['budget'] = $data['budget'] ?? null;
        $this->container['time_budget'] = $data['time_budget'] ?? null;
        $this->container['project'] = $data['project'] ?? null;
        $this->container['meta_fields'] = $data['meta_fields'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['name'] === null) {
            $invalidProperties[] = "'name' can't be null";
        }
        if ((mb_strlen($this->container['name']) > 150)) {
            $invalidProperties[] = "invalid value for 'name', the character length must be smaller than or equal to 150.";
        }

        if ((mb_strlen($this->container['name']) < 2)) {
            $invalidProperties[] = "invalid value for 'name', the character length must be bigger than or equal to 2.";
        }

        if ($this->container['visible'] === null) {
            $invalidProperties[] = "'visible' can't be null";
        }
        if ($this->container['budget'] === null) {
            $invalidProperties[] = "'budget' can't be null";
        }
        if ($this->container['time_budget'] === null) {
            $invalidProperties[] = "'time_budget' can't be null";
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
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name name
     *
     * @return $this
     */
    public function setName($name)
    {
        if ((mb_strlen($name) > 150)) {
            throw new \InvalidArgumentException('invalid length for $name when calling ActivityEntity., must be smaller than or equal to 150.');
        }
        if ((mb_strlen($name) < 2)) {
            throw new \InvalidArgumentException('invalid length for $name when calling ActivityEntity., must be bigger than or equal to 2.');
        }

        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->container['comment'];
    }

    /**
     * Sets comment
     *
     * @param string $comment comment
     *
     * @return $this
     */
    public function setComment($comment)
    {
        $this->container['comment'] = $comment;

        return $this;
    }

    /**
     * Gets visible
     *
     * @return bool
     */
    public function getVisible()
    {
        return $this->container['visible'];
    }

    /**
     * Sets visible
     *
     * @param bool $visible visible
     *
     * @return $this
     */
    public function setVisible($visible)
    {
        $this->container['visible'] = $visible;

        return $this;
    }

    /**
     * Gets fixed_rate
     *
     * @return float
     */
    public function getFixedRate()
    {
        return $this->container['fixed_rate'];
    }

    /**
     * Sets fixed_rate
     *
     * @param float $fixed_rate fixed_rate
     *
     * @return $this
     */
    public function setFixedRate($fixed_rate)
    {
        $this->container['fixed_rate'] = $fixed_rate;

        return $this;
    }

    /**
     * Gets hourly_rate
     *
     * @return float
     */
    public function getHourlyRate()
    {
        return $this->container['hourly_rate'];
    }

    /**
     * Sets hourly_rate
     *
     * @param float $hourly_rate hourly_rate
     *
     * @return $this
     */
    public function setHourlyRate($hourly_rate)
    {
        $this->container['hourly_rate'] = $hourly_rate;

        return $this;
    }

    /**
     * Gets color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->container['color'];
    }

    /**
     * Sets color
     *
     * @param string $color color
     *
     * @return $this
     */
    public function setColor($color)
    {
        $this->container['color'] = $color;

        return $this;
    }

    /**
     * Gets budget
     *
     * @return float
     */
    public function getBudget()
    {
        return $this->container['budget'];
    }

    /**
     * Sets budget
     *
     * @param float $budget budget
     *
     * @return $this
     */
    public function setBudget($budget)
    {
        $this->container['budget'] = $budget;

        return $this;
    }

    /**
     * Gets time_budget
     *
     * @return int
     */
    public function getTimeBudget()
    {
        return $this->container['time_budget'];
    }

    /**
     * Sets time_budget
     *
     * @param int $time_budget time_budget
     *
     * @return $this
     */
    public function setTimeBudget($time_budget)
    {
        $this->container['time_budget'] = $time_budget;

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
     * @param int $project project
     *
     * @return $this
     */
    public function setProject($project)
    {
        $this->container['project'] = $project;

        return $this;
    }

    /**
     * Gets meta_fields
     *
     * @return \KimaiConsole\Client\Model\ActivityMeta[]
     */
    public function getMetaFields()
    {
        return $this->container['meta_fields'];
    }

    /**
     * Sets meta_fields
     *
     * @param \KimaiConsole\Client\Model\ActivityMeta[] $meta_fields meta_fields
     *
     * @return $this
     */
    public function setMetaFields($meta_fields)
    {
        $this->container['meta_fields'] = $meta_fields;

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

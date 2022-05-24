<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHqLib\Model;


use JsonSerializable;

class Collection implements JsonSerializable, \Countable
{
    /**
     * @var array
     */
    private $elements;

    /**
     * @var string
     */
    private $key;

    /**
     * Collection constructor.
     * @param array $elements
     * @param string $key
     */
    public function __construct(array $elements, string $key = null)
    {
        $this->elements = $elements;
        $this->key = $key;
    }

    /**
     * @param $element
     */
    public function addElement($element)
    {
        $this->elements[] = $element;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): mixed
    {
        if ($this->key !== null) {
            return [$this->key => $this->elements];
        }
        return $this->elements;
    }
}
<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHqLib\Model;


use DateTime;
use DateTimeInterface;

class SearchResult implements \JsonSerializable
{
    /**
     * @var Collection
     */
    private $customerCollection;
    /**
     * @var Collection
     */
    private $orderCollection;

    /**
     * SearchResult constructor.
     * @param Collection $customerCollection
     * @param Collection $orderCollection
     */
    public function __construct(Collection $customerCollection, Collection $orderCollection)
    {
        $this->customerCollection = $customerCollection;
        $this->orderCollection = $orderCollection;
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
        return [
            'customers' => $this->customerCollection,
            'orders' => $this->orderCollection
        ];
    }
}
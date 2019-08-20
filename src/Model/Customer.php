<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHqLib\Model;

use DateTime;
use DateTimeInterface;
use Emico\RobinHqLib\Config\Config;
use JsonSerializable;

class Customer implements JsonSerializable
{
    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var DateTimeInterface
     */
    protected $customerSince;

    /**
     * @var int
     */
    protected $orderCount = 0;

    /**
     * @var float
     */
    protected $totalRevenue = 0;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var DateTimeInterface
     */
    protected $lastOrderDate;

    /**
     * @var array
     */
    protected $panelView;

    /**
     * Customer constructor.
     * @param string $emailAddress
     */
    public function __construct(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @param string $emailAddress
     */
    public function setEmailAddress(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCustomerSince(): DateTimeInterface
    {
        return $this->customerSince;
    }

    /**
     * @param DateTimeInterface $customerSince
     */
    public function setCustomerSince(DateTimeInterface $customerSince)
    {
        $this->customerSince = $customerSince;
    }

    /**
     * @return int
     */
    public function getOrderCount(): int
    {
        return $this->orderCount;
    }

    /**
     * @param int $orderCount
     */
    public function setOrderCount(int $orderCount)
    {
        $this->orderCount = $orderCount;
    }

    /**
     * @return float
     */
    public function getTotalRevenue(): float
    {
        return $this->totalRevenue;
    }

    /**
     * @param float $totalRevenue
     */
    public function setTotalRevenue(float $totalRevenue)
    {
        $this->totalRevenue = $totalRevenue;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return DateTimeInterface
     */
    public function getLastOrderDate(): ?DateTimeInterface
    {
        return $this->lastOrderDate;
    }

    /**
     * @param DateTimeInterface $lastOrderDate
     */
    public function setLastOrderDate(DateTimeInterface $lastOrderDate)
    {
        $this->lastOrderDate = $lastOrderDate;
    }

    /**
     * @return array
     */
    public function getPanelView(): ?array
    {
        return $this->panelView;
    }

    /**
     * @param array $panelView
     */
    public function setPanelView(array $panelView)
    {
        $this->panelView = $panelView;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function addPanelViewItem(string $key, $value)
    {
        $this->panelView[$key] = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getEmailAddress();
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        $data = [
            'email_address' => $this->emailAddress,
            'name' => $this->name,
            'phone_number' => $this->phoneNumber,
            'customer_since' => $this->customerSince ? $this->customerSince->format(DateTime::ISO8601) : '',
            'order_count' => $this->orderCount,
            'total_revenue' => $this->totalRevenue,
            'total_spent' => (string) $this->totalRevenue,
            'currency' => $this->currency,
        ];

        if ($this->lastOrderDate) {
            $data['last_order_date'] = $this->lastOrderDate ? $this->lastOrderDate->format(Config::JSON_DATE_FORMAT) : '';
        }

        if ($this->panelView) {
            $data['panel_view'] = $this->panelView;
        }

        return $data;
    }
}

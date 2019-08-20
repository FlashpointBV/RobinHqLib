<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHqLib\Model;


use DateTime;
use DateTimeInterface;
use Emico\RobinHqLib\Config\Config;
use Emico\RobinHqLib\Model\Order\DetailsView;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Order implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $orderNumber;

    /**
     * @var string
     */
    protected $emailAddress;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var float
     */
    protected $revenue;

    /**
     * @var float
     */
    protected $oldRevenue;

    /**
     * @var float
     */
    protected $profit;

    /**
     * @var float
     */
    protected $oldProfit;

    /**
     * @var DateTimeInterface
     */
    protected $orderDate;

    /**
     * @var bool
     */
    protected $firstOrder = false;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $webstoreUrl;

    /**
     * @var array
     */
    protected $listView;

    /**
     * @var array
     */
    protected $detailsViews;

    /**
     * Order constructor.
     * @param string $orderNumber
     */
    public function __construct(string $orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     */
    public function setOrderNumber(string $orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     */
    public function setEmailAddress(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
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
     * @return DateTimeInterface
     */
    public function getOrderDate(): DateTimeInterface
    {
        return $this->orderDate;
    }

    /**
     * @param DateTimeInterface $orderDate
     */
    public function setOrderDate(DateTimeInterface $orderDate)
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return float
     */
    public function getRevenue(): float
    {
        return $this->revenue;
    }

    /**
     * @param float $revenue
     */
    public function setRevenue(float $revenue)
    {
        $this->revenue = $revenue;
    }

    /**
     * @return float
     */
    public function getOldRevenue(): float
    {
        return $this->oldRevenue;
    }

    /**
     * @param float $oldRevenue
     */
    public function setOldRevenue(float $oldRevenue)
    {
        $this->oldRevenue = $oldRevenue;
    }

    /**
     * @return float
     */
    public function getProfit(): ?float
    {
        return $this->profit;
    }

    /**
     * @param float $profit
     */
    public function setProfit(float $profit = null)
    {
        $this->profit = $profit;
    }

    /**
     * @return float
     */
    public function getOldProfit(): ?float
    {
        return $this->oldProfit;
    }

    /**
     * @param float $oldProfit
     */
    public function setOldProfit(float $oldProfit)
    {
        $this->oldProfit = $oldProfit;
    }

    /**
     * @return bool
     */
    public function isFirstOrder(): bool
    {
        return $this->firstOrder;
    }

    /**
     * @param bool $firstOrder
     */
    public function setFirstOrder(bool $firstOrder)
    {
        $this->firstOrder = $firstOrder;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getWebstoreUrl()
    {
        return $this->webstoreUrl;
    }

    /**
     * @param string $webstoreUrl
     */
    public function setWebstoreUrl(string $webstoreUrl)
    {
        $this->webstoreUrl = $webstoreUrl;
    }

    /**
     * @return array
     */
    public function getListView(): ?array
    {
        return $this->listView;
    }

    /**
     * @param array $listView
     */
    public function setListView(array $listView)
    {
        $this->listView = $listView;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addListViewItem(string $key, $value)
    {
        $this->listView[$key] = $value;
    }

    /**
     * @return array
     */
    public function getDetailsView(): ?array
    {
        return $this->detailsViews;
    }

    /**
     * @param array $detailsView
     */
    public function setDetailsView(array $detailsView)
    {
        $this->detailsViews = $detailsView;
    }

    /**
     * @param DetailsView $detailsView
     */
    public function addDetailsView(DetailsView $detailsView)
    {
        $this->detailsViews[] = $detailsView;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $data = [
            'order_number' => $this->orderNumber,
            'email_address' => $this->emailAddress,
            'name' => $this->name,
            'revenue' => $this->revenue,
            'old_revenue' => $this->oldRevenue,
            'order_date' => $this->orderDate->format(Config::JSON_DATE_FORMAT),
            'is_first_order' => $this->firstOrder
        ];

        if ($this->oldProfit !== null) {
            $data['old_profit'] = $this->oldProfit;
        }

        if ($this->profit !== null) {
            $data['profit'] = $this->profit;
        }

        if ($this->url !== null) {
            $data['url'] = $this->url;
        }
        
        if ($this->webstoreUrl !== null) {
            $data['webstore_url'] = $this->webstoreUrl;
        }

        if ($this->detailsViews !== null) {
            $data['details_view'] = $this->detailsViews;
        }

        if ($this->listView !== null) {
            $data['list_view'] = array_map(
                function ($listViewItem) {
                    if ($listViewItem instanceof DateTimeInterface) {
                        $listViewItem = $listViewItem->format('Y-m-d h:i:s');
                    }
                    return $listViewItem;
                },
                $this->listView
            );
        }

        return $data;
    }
}
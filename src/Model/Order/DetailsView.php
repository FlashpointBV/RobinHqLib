<?php
/**
 * @author Bram Gerritsen <bgerritsen@emico.nl>
 * @copyright (c) Emico B.V. 2017
 */

namespace Emico\RobinHqLib\Model\Order;

use DateTimeInterface;
use Emico\RobinHqLib\Config\Config;
use JsonSerializable;

class DetailsView implements JsonSerializable
{
    /**
     * Display mode constants
     */
    const DISPLAY_MODE_DETAILS = 'details';
    const DISPLAY_MODE_COLUMNS = 'columns';
    const DISPLAY_MODE_ROWS = 'rows';

    /**
     * @var string
     */
    protected $displayAs;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $caption;

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d h:i:s';

    /**
     * DetailsView constructor.
     * @param string $displayAs
     * @param array $data
     */
    public function __construct(string $displayAs, array $data)
    {
        $this->displayAs = $displayAs;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getDisplayAs(): string
    {
        return $this->displayAs;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function addData(string $key, string $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @return string|null
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     */
    public function setCaption(string $caption)
    {
        $this->caption = $caption;
    }

    /**
     * @param string $dateFormat
     */
    public function setDateFormat(string $dateFormat)
    {
        $this->dateFormat = $dateFormat;
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
        $data = ['display_as' => $this->displayAs];

        if ($this->caption) {
            $data['caption'] = $this->caption;
        }

        $data['data'] = array_map(function($val) {
            if ($val instanceof DateTimeInterface) {
                return $val->format($this->dateFormat);
            }
            return $val;
        }, $this->data);

        return $data;
    }
}
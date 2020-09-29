<?php

namespace testTaskDelivery;

class DeliveryNote
{
    /** @var string */
    private $guid;

    /** @var string */
    private $type;

    /** @var string */
    private $from;

    /** @var string */
    private $to;

    /** @var string */
    private $company;

    /**
     * DeliveryNote constructor.
     * @param string $type
     * @param string $from
     * @param string $to
     * @param string $company
     * @throws \Exception
     */
    public function __construct(string $type, string $from, string $to, string $company)
    {
        $this->guid = bin2hex(random_bytes(10));
        $this->type = $type;
        $this->from = $from;
        $this->to = $to;
        $this->company = $company;
    }

    /**
     * @param DeliveryNote $left
     * @param DeliveryNote $right
     * @return bool
     */
    public static function compare(DeliveryNote $left, DeliveryNote $right)
    {
        return $left->getFrom() === $right->getFrom()
            && $left->getTo() === $right->getTo()
            && $left->getType() === $right->getType()
            && $left->getCompany() === $right->getCompany();
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }
}
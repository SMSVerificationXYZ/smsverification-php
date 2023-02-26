<?php

namespace SMSVerification\Models\Rental;

class Order
{
    private int $id;
    private string $number;
    private string $purchaseDate;
    private string $expireDate;
    private bool $cancelable;
    private bool $expired;
    private array $messages;

    /**
     * @param int $id
     * @param string $number
     * @param string $purchaseDate
     * @param string $expireDate
     * @param bool $canCancel
     * @param bool $expired
     * @param array $messages
     */
    public function __construct(int $id, string $number, string $purchaseDate, string $expireDate, bool $canCancel, bool $expired, array $messages)
    {
        $this->id = $id;
        $this->number = $number;
        $this->purchaseDate = $purchaseDate;
        $this->expireDate = $expireDate;
        $this->cancelable = $canCancel;
        $this->expired = $expired;
        $this->messages = $messages;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getPurchaseDate(): string
    {
        return $this->purchaseDate;
    }

    /**
     * @return string
     */
    public function getExpireDate(): string
    {
        return $this->expireDate;
    }

    /**
     * @return bool
     */
    public function isCancelable(): bool
    {
        return $this->cancelable;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expired;
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function toArray(): array {
        return [
            "id" => $this->getId(),
            "number" => $this->getNumber(),
            "purchased_at" => $this->getPurchaseDate(),
            "expires_at" => $this->getExpireDate(),
            "can_cancel" => $this->isCancelable(),
            "expired" => $this->isExpired(),
            "messages" => $this->getMessages()
        ];
    }
}
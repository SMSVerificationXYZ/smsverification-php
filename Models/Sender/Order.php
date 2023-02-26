<?php

namespace SMSVerification\Models\Sender;

class Order
{
    private int $id;
    private string $recipient;
    private string $message;
    private float $price;
    private string $date;
    private string $status;

    /**
     * @param int $id
     * @param string $recipient
     * @param string $message
     * @param float $price
     * @param string $date
     * @param string $status
     */
    public function __construct(int $id, string $recipient, string $message, float $price, string $date, string $status)
    {
        $this->id = $id;
        $this->recipient = $recipient;
        $this->message = $message;
        $this->price = $price;
        $this->date = $date;
        $this->status = $status;
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
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
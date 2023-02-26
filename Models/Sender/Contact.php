<?php

namespace SMSVerification\Models\Sender;

class Contact
{
    private int $id;
    private string $name;
    private string $number;
    private string $createdAt;

    /**
     * @param int $id Unique contact id
     * @param string $name Name of the contact
     * @param string $number Contact's number
     * @param string $createdAt Creation date
     */
    public function __construct(int $id, string $name, string $number, string $createdAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->number = $number;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int Unique contact id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string Name of the contact
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string Contact's number
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string Creation date
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
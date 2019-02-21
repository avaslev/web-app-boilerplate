<?php


namespace App\Message;


class ContextMediaMessage
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $class;

    public function __construct(int $id, string $class)
    {
        $this->id = $id;
        $this->class = $class;
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
    public function getClass(): string
    {
        return $this->class;
    }

}

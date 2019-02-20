<?php


namespace App\Message;


class MediaMessage
{
    const ACTION_SAVE = 'save';
    const ACTION_DELETE = 'delete';
    const ACTION_PRODUCE = 'produce';
    /**
     * @var string
     */
    private $media;
    /**
     * @var string
     */
    private $action;
    /**
     * @var string
     */
    private $query;
    /**
     * @var array
     */
    private $context;


    public function __construct(string $action, string $media = '', string $query = '', array $context = [])
    {
        $this->media = $media;
        $this->action = $action;
        $this->query = $query;
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getMedia(): string
    {
        return $this->media;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @param string $media
     * @return MediaMessage
     */
    public function setMedia(string $media): MediaMessage
    {
        $this->media = $media;
        return $this;
    }

    /**
     * @param string $action
     * @return MediaMessage
     */
    public function setAction(string $action): MediaMessage
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @param string $query
     * @return MediaMessage
     */
    public function setQuery(string $query): MediaMessage
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param array $context
     * @return MediaMessage
     */
    public function setContext(array $context): MediaMessage
    {
        $this->context = $context;
        return $this;
    }


}

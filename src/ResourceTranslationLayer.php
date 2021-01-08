<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace Resource;

trait ResourceTranslationLayer
{
    /**
     * Get instance of resource.
     *
     * @var|object
     */
    protected $resource;

    /**
     * Indicates if the resource is of type object.
     *
     * @var bool
     */
    protected $isObject = false;

    /**
     * Determine if the resource is of type object.
     *
     * @return bool
     */
    public function isObject(): bool
    {
        return $this->isObject;
    }

    /**
     * Destroy instance of resource.
     *
     * @return void
     */
    public function __destruct()
    {
        $this->close();
    }
}

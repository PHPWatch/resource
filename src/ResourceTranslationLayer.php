<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace Resource;

trait ResourceTranslationLayer
{
    protected $resource;

    protected $isObject = false;

    public function isObject(): bool {
        return $this->isObject;
    }

    public function __destruct() {
        $this->close();
    }
}

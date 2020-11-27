<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace Resource;

trait ResourceTranslationLayer {

    /**
     * @var $resource|object
     */
    protected $resource;
    protected bool $isObject;

    protected function isObject(): bool {
        return $this->isObject;
    }

    public function __destruct() {
        $this->close();
    }
}

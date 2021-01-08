<?php

namespace Resource;

interface Resource
{
    /**
     * Close the resource, and free up system resources.
     *
     * @return void
     */
    public function close(): void;
}

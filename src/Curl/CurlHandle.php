<?php

/** @noinspection PhpComposerExtensionStubsInspection */

namespace Resource\Curl;

use Resource\Resource;
use Resource\ResourceTranslationLayer;

class CurlHandle implements Resource
{
    use ResourceTranslationLayer;

    public static function init(?string $url = null) {
        $resource = curl_init($url);

        if ($resource === false) {
            return false;
        }

        $instance = new static();
        $instance->resource = $resource;

        return $instance;
    }

    public function close(): void {
        if ($this->isObject) {
            curl_close($this->resource);

            return;
        }
    }

    public function copyHandle() {
        $object = curl_copy_handle($this->resource);

        if ($object === false) {
            return false;
        }

        $return = new static();
        $return->resource = $object;

        return $return;
    }

    public function errno(): int {
        return curl_errno($this->resource);
    }

    public function error(): string {
        return curl_error($this->resource);
    }

    public function escape(string $string) {
        return curl_escape($this->resource, $string);
    }

    public function exec() {
        return curl_exec($this->resource);
    }

    public function getinfo(?int $option = null) {
        return curl_getinfo($this->resource, $option);
    }
}

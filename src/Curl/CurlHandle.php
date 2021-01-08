<?php

/** @noinspection PhpComposerExtensionStubsInspection */

namespace Resource\Curl;

use Resource\Resource;
use Resource\ResourceTranslationLayer;

class CurlHandle implements Resource
{
    use ResourceTranslationLayer;

    /**
     * Initialize a cURL session.
     *
     * @param string|null $url
     *
     * @return static|false
     */
    public static function init(?string $url = null)
    {
        $resource = curl_init($url);

        if ($resource === false) {
            return false;
        }

        $instance = new static();
        $instance->resource = $resource;

        return $instance;
    }

    /**
     * Close the resource, and free up system resources.
     *
     * @return void
     */
    public function close(): void
    {
        if ($this->isObject) {
            curl_close($this->resource);

            return;
        }
    }

    /**
     * Copy a cURL handle along with all of its preferences.
     *
     * @return \Resource\Curl\CurlHandle|false
     */
    public function copyHandle()
    {
        $object = curl_copy_handle($this->resource);

        if ($object === false) {
            return false;
        }

        $return = new static();
        $return->resource = $object;

        return $return;
    }

    /**
     * Return the last error number.
     *
     * @return int
     */
    public function errno(): int
    {
        return curl_errno($this->resource);
    }

    /**
     * Return a string containing the last error for the current session.
     *
     * @return string
     */
    public function error(): string
    {
        return curl_error($this->resource);
    }

    /**
     * URL encodes the given string.
     *
     * @param string $string
     *
     * @return string|false
     */
    public function escape(string $string)
    {
        return curl_escape($this->resource, $string);
    }

    /**
     * Perform a cURL session.
     *
     * @return string|bool
     */
    public function exec()
    {
        return curl_exec($this->resource);
    }

    /**
     * Get information regarding a specific transfer.
     *
     * @param int|null $option
     *
     * @return mixed
     */
    public function getinfo(?int $option = null)
    {
        return curl_getinfo($this->resource, $option);
    }
}

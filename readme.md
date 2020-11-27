# PHP Resource Objects

Provides a translation layer for PHP's `resource` objects by encapsulating `resource` objects, and providing an object-oriented interface for them.

## What is a PHP `resource`

In PHP, a `resource` is a special variable that holds a reference, or a "handle", to an external resource. A Curl handler is a prime example of a PHP `resource`, that a Curl `resource` refers to a Curl instance (from `libcurl`).

`resource` objects can maintain state. A Curl resource for example contains the headers in request, the response body, number of redirects, etc. 

PHP `resource` objects, although they provide similar functionality of standard PHP classes, cannot be manipulated as if they are class objects. PHP `resource` objects must be handled with several functions, and the `resource` object itself cannot contain any properties. 

`resource` is a PHP soft-reserved keyword, but there is no real `resource` type in PHP, and it is not possible to declare `resource` types for parameters, return types, or class properties either. 

## On moving to Resource Objects

`resource` objects are not standard PHP objects, and they cannot be serialized, or otherwise handled in any manner that standard PHP class objects abide to. 

One of the PHP's long terms goals is [moving away from the traditional `resource` objects](https://php.watch/articles/resource-object). Curl handlers, GD extension images, FTP connections, etc were traditionally of PHP's `resource` data type. To handle those resources, it required several individual functions, and there was no consistency that a PHP class would have provided.

In PHP 8.0, [PHP converts several of `resource` objects to standard PHP class objects](https://php.watch/versions/8.0#resource-object). [PHP 8.1](https://php.watch/versions/8.1) will continue these efforts too, with GDFont, and FTP connection resource objects already converted for PHP 8.1. 

## `phpwatch/resource` library

This library attempts to bring the resource objects to all PHP versions that this library supports. 

This library provides PHP classes that map to PHP traditional `resource`  and migrated resource classes. the goal of this library is to provide the same resource object convenience to all PHP versions.

### Resource Types

`resource` is not a type that you can declare in parameter/return/property types. Resource objects from this library are standard PHP classes that can be used as a type. 

```php
use Resource\Curl\CurlHandle;

function run(CurlRequest $request) {
    return $request->exec();
}
```

### OOP-interfaces

All resource object classes provide an object-oriented interface for the resource object. 

For example, the `Resource\Curl\CurlHandle::exec` class method provides same functionality as `curl_exec`. 

```php
$curl = curl_init('https://php.watch');
curl_exec(curl);
```

This functionality can be converted to an object-oriented code with this library:

```php
use Resource\Curl\CurlHandle;

$curl = new CurlHandle('https://php.watch');
$curl->exec();
```

### Consistency

With PHP's updated resource objects, the resource is automatically cleared when the referenced object falls out of scope, or when it's explicitly unset (`unset($handler)`). 

This library brings this functionality to all PHP versions, and does so in a consistent way. 

For example, prior to PHP 8.0, the `xml_parser_free` function call was necessary to free up the memory. In PHP 8.0, the [migrated `XMLParser`](https://php.watch/versions/8.0/xmlwriter-resource) does it automatically. `xml_parser_free` is still available in PHP 8.0, but OpenSSL extension's [`openssl_pkey_free()` function is deprecated in PHP 8.0](https://php.watch/versions/8.0/OpenSSL-resource#openssl-deprecations).  

This library can work-out the version differences, and call the `xml_parser_free` function automatically when using PHP 7.4. For OpenSSL objects, this library hides the complexity of checking the PHP version before calling the deprecated `openssl_pkey_free`. 

The caller does not need to know the inner details of PHP's `resource` to object migration, because this library provides the translation layer to seamlessly work-out the inner differences in the object migration. 

### Semantics

All Resource objects from this library are crafted to provide an intuitive interface. The class constructors and either marked `private` to prevent direct instantiation, or the constructors map to the only function that creates a trantional PHP `resource`. 

Furthermore, when a `resource` cannot be serialized, or otherwise imposes other restrictions, that is conveyed with PHP class visibility and exception mechanisms. 

### Cross-version compatibility

This library provides a SEMVER promise to maintain cross-version compatibility with PHP versions. For example, `Resource\Curl\CurlHandle` class API will be exactly the same for all supported PHP versions, even on PHP versions that use trantional `resource` objects, or PHP ever adds an OOP functionality to the PHP core's `\CurlHandle` object.


---


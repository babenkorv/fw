<?php

namespace vendor\psr7;

use vendor\psr7\psr7interface\ServerRequestInterface;
use vendor\psr7\psr7interface\StreamInterface;
use vendor\psr7\psr7interface\UriInterface;

class HttpServerRequest extends HttpRequest implements ServerRequestInterface
{
    private $attribute = [];
    private $cookieParams = [];
    private $parseBody;
    private $queryParams = [];
    private $serverParams;
    private $uplpadedFiles = [];

    /**
     * HttpServerRequest constructor.
     * 
     * @param string $method request method (get, post ...).
     * @param UriInterface $uri Uri link.
     * @param array $headers array with request header.
     * @param StreamInterface $body request body.
     * @param string $version protocol version.
     * @param array $serverParams array with server parameters.
     */
    public function __construct($method, UriInterface $uri, array $headers, StreamInterface $body, $version, array $serverParams = [])
    {
        $this->serverParams = $serverParams;

        parent::__construct($method, $uri, $headers, $body, $version);
    }

    /**
     * Set cookies.
     * 
     * @param array $cookies array with cookies.
     * @return object $this HttpServerReques object.
     */
    public function withCookieParams(array $cookies)
    {
        $this->cookieParams = $cookies;

        return $this;
    }


    /**
     * Return cookie params.
     *
     * @return array
     */
    public function getCookieParams()
    {
        return $this->cookieParams;
    }


    /**
     * Set uploads files.
     *
     * @param array $uploadedFiles.
     * @return object $this.
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        $this->uplpadedFiles = $uploadedFiles;

        return $this;
    }

    /**
     * Return uploads files.
     *
     * @return array
     */
    public function getUploadedFiles()
    {
        return $this->uplpadedFiles;
    }

    /**
     * Return server param.
     *
     * @return array
     */
    public function getServerParams()
    {
        return $this->serverParams;
    }

    /**
     * Set request body.
     *
     * @param array|null|object $data
     * @return $this
     */
    public function withParsedBody($data)
    {
        $this->parseBody = $data;

        return $this;
    }

    /**
     * Return parse body.
     *
     * @return mixed
     */
    public function getParsedBody()
    {
        return $this->parseBody;
    }

    /**
     * Set query params.
     *
     * @param array $query query params.
     * @return object $this
     */
    public function withQueryParams(array $query)
    {
        $this->queryParams = $query;

        return $this;
    }

    /**
     * Return query params.
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Set attribute.
     *
     * @param string $name attribute name.
     * @param mixed $value attribute value.
     * @return object $this
     */
    public function withAttribute($name, $value)
    {
        $this->attribute[$name] = $value;

        return $this;
    }

    /**
     * Remove attribute with @param $name
     *
     * @param string $name name attribute.
     * @return object $this
     */
    public function withoutAttribute($name)
    {
        if (array_key_exists($name, $this->attribute)) {
            unset($this->attribute[$name]);
        }

        return $this;
    }

    /**
     * Return attribute with name. If attribute with name not find return @param $default.
     *
     * @param string $name attribute name.
     * @param string|null $default default attribute value.
     * @return mixed|null
     */
    public function getAttribute($name, $default = null)
    {
        if (array_key_exists($name, $this->attribute)) {
            return $this->attribute[$name];
        } else {
            return $default;
        }
    }

    /**
     * Return all atributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attribute;
    }
}
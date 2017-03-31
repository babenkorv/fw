<?php

namespace vendor\psr7;

use vendor\psr7\psr7interface\MessageInterface;
use vendor\psr7\psr7interface\StreamInterface;

abstract class HttpMessage implements MessageInterface
{
    protected $protocolVersion = '1.1';

    private $headers = [];

    protected $body;

    /**
     * Return http protocol version.
     *
     * @return string mixed
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * Set and return protocol version.
     *
     * @param string $version http protocol version.
     * @return mixed
     */
    public function withProtocolVersion($version)
    {
        $this->protocolVersion = $version;

        return $this;
    }

    /**
     * If header with $name exist return true, else return false.
     *
     * @param string $name header field name.
     * @return bool
     */
    public function hasHeader($name)
    {
        return isset($this->headers[strtolower($name)]);
    }
    
    /**
     * Return array with headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Return header value with name = $name.
     *
     * @param string $name header field name.
     * @return mixed
     */
    public function getHeader($name)
    {
        if ($this->hasHeader($name)) {
            return $this->headers[strtolower($name)];
        } else {
            return [];
        }
    }

    /**
     * Return header with field name = $name in string format.
     * 
     * @param string $name header field name.
     * @return mixed
     */
    public function getHeaderLine($name)
    {
        return implode(', ', $this->getHeader($name));
    }

    /**
     * Add new or update headers.
     * 
     * @param string $name header field name
     * @param string|\string[] $value header value
     * @return $this
     */
    public function withHeader($name, $value)
    {
        $lowerName = strtolower($name);

        if (is_array($value)) {
            $this->headers[$lowerName] = $value;
        } else {
            $this->headers[$lowerName] = [$value];
        }
        
        return $this;
    }

    /**
     * Add new header value to exists header field or if header field is no exist add new header.
     *
     * @param string $name header filed name.
     * @param string|\string[] $value header value.
     * @return $this
     */
    public function withAddedHeader($name, $value)
    {
        $lowerName = strtolower($name);

        if ($this->hasHeader($lowerName)) {
            if (is_array($value)) {
                foreach ($value as $key => $item) {
                    $this->headers[$lowerName][$key] = $item;
                }
            } else {
                array_push($this->headers[$lowerName], $value);
            }
        } else {
            $this->withHeader($name, $value);
        }

        return $this;
    }

    /**
     * Remove header field with name = $name.
     * 
     * @param string $name header filed name.
     * @return $this
     */
    public function withoutHeader($name)
    {
        $lowerName = strtolower($name);

        if($this->hasHeader($lowerName)) {  
            unset($this->headers[$name]);
        }

        return $this;
    }

    /**
     * Set message body.
     * 
     * @param StreamInterface $body message body.
     * @return $this
     */
    public function withBody(StreamInterface $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Return message body.
     * 
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Add to headers new header form assoc array [header=>[value]].
     *
     * @param array $headers array with request headers.
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $header => $value) {
            if (!is_array($value)) {
                $value = [$value];
            }

            $lowerHeader = strtolower($header);

            if(isset($this->headers[$lowerHeader])) {
                $this->headers[$lowerHeader] = array_merge($this->headers[$lowerHeader], $value);
            } else {
                $this->headers[$lowerHeader] = $value;
            }
        }
    }
}
<?php

namespace vendor\psr7;

use vendor\psr7\psr7interface\RequestInterface;
use vendor\psr7\psr7interface\StreamInterface;
use vendor\psr7\psr7interface\UriInterface;

class HttpRequest extends HttpMessage implements RequestInterface
{
    private $uri;
    private $requestTarget;
    private $method;

    /**
     * HttpRequest constructor.
     * 
     * @param string $method request method (get, post ...).
     * @param HttpUri $uri request uri.
     * @param array $headers array with request headers.
     * @param StreamInterface|null $body request message. 
     * @param string $version version protocol.
     */
    public function __construct($method = 'post', HttpUri $uri, $headers = [], HttpStream $body = null, $version = '1.1')
    {
        $this->method = strtoupper($method);
        $this->uri = $uri;
        $this->setHeaders($headers);
        $this->body = $body;
        $this->protocolVersion = $version;
    }

    /**
     * Set new Uri. If request have uri this method not update him.
     *
     * @param UriInterface $uri request uri.
     * @param bool $preserveHost host setting.
     * @return object $this HttpRequest.
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        if ($preserveHost) {
            $this->uri->getHost();

            if ($this->uri->getHost() == '' && $uri->getHost() != '') {
                $this->uri->withHost($uri->getHost());
            }
            if ($this->uri->getHost() != '') {
                return $this;
            }
            if ($this->uri->getHost()  == '' && $uri->getHost() == '') {
                return $this;
            }
        }
    }

    /**
     * @return object UriInterface uri.
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set request-target.
     *
     * @param string $requestTarget link on target request.
     * @return object $this HttpRequest.
     * @throws \Exception
     */
    public function withRequestTarget($requestTarget)
    {
        if (preg_match('#\s#', $requestTarget)) {
            throw new \Exception(
                'Invalid request target provided; cannot contain whitespace'
            );
        }

        $this->requestTarget = $requestTarget;

        return $this;
    }

    /**
     * Return request target. If request target === null return '/' + query.
     *
     * @return string
     */
    public function getRequestTarget()
    {
        $target = '';
        if($this->requestTarget != null) {
            return $this->requestTarget;
        }

        if ($this->uri->getPath() === null) {
            $target = '/';
        }

        if ($this->uri->getQuery() != null) {
            $target .= '?' . $this->uri->getQuery();
        }

        return $target;
    }

    /**
     * Ste http method (GET, POST, ...).
     *
     * @param string $method request method (get, post ...).
     * @return object $this HttpRequest.
     */
    public function withMethod($method)
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * Return method.
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }
}
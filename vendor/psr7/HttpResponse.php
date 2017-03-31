<?php

namespace vendor\psr7;

use vendor\psr7\psr7interface\ResponseInterface;
use vendor\psr7\psr7interface\StreamInterface;

class HttpResponse extends HttpMessage implements ResponseInterface
{
    private static $phrases = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];

    private $status;
    private $reasonPhrase;

    /**
     * HttpResponse constructor.
     *
     * @param int $status response status.
     * @param array $headers array with response headers.
     * @param StreamInterface $body response message.
     * @param string $version response protocol version.
     * @param string $reason description response status.
     */
    public function __construct($status = 200, array $headers = [], HttpStream $body, $version = '1.1', $reason = null)
    {
        $this->status = $status;
        $this->setHeaders($headers);
        if ($reason === null && isset(self::$phrases[$status])) {
            $reason = self::$phrases;
        } else {
            $this->reasonPhrase = $reason;
        }

        $this->protocolVersion = $version;

        $this->body = $body;
    }

    /**
     * Add status to response.
     * 
     * @param int $code status code.
     * @param string $reasonPhrase description status.
     * @return object $this HttpResponse. 
     * @throws \Exception
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        if($reasonPhrase === '') {
            if (array_key_exists($code, self::$phrases)) {
                $this->status = $code;
                $this->reasonPhrase = self::$phrases[$code];
            } else {
                throw new \Exception('code is not default, set code reason');
            }
        } else {
            $this->status = $code;
            $this->reasonPhrase = $reasonPhrase;
        }

        return $this;
    }

    /**
     * Return response status code.
     * 
     * @return int 
     */
    public function getStatusCode()
    {
        return $this->status;
    }

    /**
     * Return description response status code.
     * 
     * @return null|string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }
}
<?php

namespace vendor\psr7;

use vendor\psr7\psr7interface\UriInterface;

class HttpUri implements UriInterface
{

    private $uri;

    private $scheme = '';

    private $allowSheme = [
        'http',
        'https',
    ];

    private $userInfo = '';

    private $host = '';

    private $port;

    private $path = '';

    private $query = '';

    private $fragment = '';

    /**
     * HttpUri constructor.
     * @param string $uri uri
     */
    public function __construct($uri = '')
    {
        if ($uri != '') {
            $partUri = parse_url($uri);
            if (isset($partUri['scheme'])) {
                $this->scheme = $partUri['scheme'];
            }
            if (isset($partUri['host'])) {
                $this->host = $partUri['host'];
            }
            if (isset($partUri['port'])) {
                $this->port = $partUri['port'];
            }
            if (isset($partUri['user'])) {
                $this->userInfo = $partUri['user'] . ':' . (isset($partUri['pass']) ? $partUri['pass'] : '');
            }
            if (isset($partUri['query'])) {
                $this->query = $partUri['query'];
            }
            if (isset($partUri['fragment'])) {
                $this->fragment = $partUri['fragment'];
            }
        }
    }

    /**
     * Compare path uri to uri string.
     * 
     * @param string $scheme uri scheme.
     * @param string $authority uri authority.
     * @param string $path uri path.
     * @param string $query uri query.
     * @param string $fragment uri fragment.
     * @return string 
     */
    public static function createUriString($scheme, $authority, $path, $query, $fragment)
    {
        $uri = '';

        if ($scheme != '') {
            $uri .= $scheme . ':';
        }
        if ($authority != '') {
            $uri .= '//' . $authority;
        }
        $uri .= $path;
        if ($query != '') {
            $uri .= '?' . $query;
        }
        if ($fragment != '') {
            $uri .= '#' . $fragment;
        }

        return $uri;
    }

    /**
     * Return uri string.
     * 
     * @return string uri.
     */
    public function __toString()
    {
        return self::createUriString(
            $this->scheme,
            $this->getAuthority(),
            $this->path,
            $this->query,
            $this->fragment
        );
    }

    /**
     * Set scheme (http or https).
     *
     * @param string $scheme uri scheme.
     * @return object $this.
     * @throws \Exception
     */
    public function withScheme($scheme)
    {
        $lowerScheme = strtolower($scheme);

        if (in_array($lowerScheme, $this->allowSheme)) {
            $this->scheme = strtolower($scheme);
        } else {
            throw new \Exception('Use default scheme(http, https)');
        }
        return $this;
    }

    /**
     * Return scheme.
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }
    
    /**
     * Set host.
     *
     * @param string $host
     * @return object $this
     */
    public function withHost($host)
    {
        if (is_string($host)) {
            $this->host = strtolower($host);
            return $this;
        } else {
            throw new \Exception('Host must be string');
        }

    }

    /**
     * Return host name.
     *
     * @return string
     */
    public function getHost()
    {
        if (!empty($this->host)) {
            return $this->host;
        } else {
            return '';
        }
    }

    /**
     * Set uri port.
     * 
     * @param int|null $port uri port
     * @return object $this
     */
    public function withPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Return uri port.
     * 
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }


    /**
     * Create authority string.
     *
     * @return string
     */
    public function getAuthority()
    {
        $authority = $this->host;

        if ($this->userInfo != '') {
            $authority = $this->userInfo . '@' . $authority;
        }

        if ($this->port != null) {
            $authority .= ':' . $this->port;
        }

        return $authority;
    }

    /**
     * Set uri user info path.
     * 
     * @param string $user user name.
     * @param string|null $password user password.
     * @return object $this.
     */
    public function withUserInfo($user, $password = null)
    {
        $this->userInfo = $user . ':' . $password;

        return $this;
    }

    /**
     * Return user info
     * 
     * @return string
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * Set uri path.
     * 
     * @param string $path uri path part.
     * @return object $this
     */
    public function withPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Return uri path.
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set uri fragment.
     * 
     * @param string $fragment uri fragment path.
     * @return object $this
     */
    public function withFragment($fragment)
    {
        $this->fragment = $fragment;

        return $this;
    }

    /**
     * Return uri fragment.
     * 
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * Set uri query.
     * 
     * @param string $query uri query path.
     * @return object $this.
     */
    public function withQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Return uri query path.
     * 
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

}
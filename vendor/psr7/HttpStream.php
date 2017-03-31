<?php

namespace vendor\psr7;

use vendor\psr7\psr7interface\StreamInterface;

class HttpStream implements StreamInterface
{
    private $stream;
    private $size;
    private $meta;
    private $seekable;
    private $readable;
    private $writable;
    private $uri;

    /**
     * HttpStream constructor.
     *
     * @param resource $stream resourse with file.
     * @param string $mode type access to file.
     */
    public function __construct($stream, $mode = 'r')
    {
        if (is_resource($stream)) {
            $this->stream = $stream;
            $this->size = fstat($this->stream)['meta'];
            $this->meta = stream_get_meta_data($this->stream);
            $this->writable = is_writable($this->meta['uri']);
            $this->readable = is_readable($this->meta['uri']);
            $this->seekable = $this->meta['seekable'];
            $this->uri = $this->meta['uri'];
        } else {
            throw new \Exception('$stream must be a resource');
        }
    }

    /**
     * Return all resource content.
     *
     * @return string
     */
    public function __toString()
    {
        $this->seek(0);
        return $this->getContents();
    }

    /**
     * Read data from the stream.
     *
     * @param int $length count byte to read.
     * @return mixed read characters.
     * @throws \Exception
     */
    public function read($length)
    {
        if (!$this->readable) {
            throw new \Exception('Stream is not readable');
        }
        $result = fread($this->stream, $length);
        if ($result == false) {
            throw new \Exception('Reading error');
        };

        return $result;
    }

    /**
     * Write string in stream resource.
     *
     * @param string $string string with data.
     * @return mixed
     * @throws \Exception
     */
    public function write($string)
    {
        if (!$this->writable) {
            throw new \Exception('Stream is not writable');
        }
        $result = fwrite($this->stream, $string);
        if ($result == false) {
            throw new \Exception('Writing error');
        };
        
        $this->size = null;

        return $result;
    }

    /**
     * Return size file on stream.
     *
     * @return null
     */
    public function getSize()
    {
        if ($this->stream != null) {
            return $this->size;
        } else {
            return null;
        }
    }

    /**
     * Return now pointer positions in stream.
     *
     * @return mixed
     */
    public function tell()
    {
        return ftell($this->stream);
    }

    /**
     * Set stream offset.
     *
     * @param int $offset count bytes to offset.
     * @param int $whence type pointer.
     * @throws \Exception
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        if (!$this->seekable) {
            throw new \RuntimeException('Stream is not seekable');
        } elseif (fseek($this->stream, $offset, $whence) === -1) {
            throw new \RuntimeException('Unable to seek to stream position '
                . $offset . ' with whence ' . var_export($whence, true));
        }
    }

    /**
     * Set stream pointer on 0.
     *
     * @throws \Exception
     */
    public function rewind()
    {
        if ($this->seekable) {
            $this->seek(0);
        } else {
            throw new \Exception('Stream is not seekable');
        }
    }

    /**
     * Return true if file ready for writing.
     *
     * @return mixed
     */
    public function isWritable()
    {
        return $this->writable;
    }

    /**
     * Return true if file ready for reading.
     *
     * @return mixed
     */
    public function isReadable()
    {
        return $this->readable;
    }

    /**
     * Return seekable. If seekable == true stream is ready for writing.
     *
     * @return bool
     */
    public function isSeekable()
    {
        return $this->seekable;
    }

    /**
     * Set stream is in an unusable state.
     */
    public function detach()
    {
        $this->readable = false;
        $this->writable = false;
        $this->seekable = false;
        $this->size = 0;
        $this->meta = [];
        $this->uri = '';
        $this->stream = null;
    }

    /**
     * Closes the stream.
     */
    public function close()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
            $this->detach();
        }
    }

    /**
     * Return true if seek pointer on eof, else return false.
     *
     * @return bool
     */
    public function eof()
    {
        if (feof($this->stream)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return metadata with key.
     *
     * @param string $key metadata key.
     * @return mixed
     */
    public function getMetadata($key = null)
    {
        if ($key == null) {
            return $this->meta;
        } else {
            return $this->meta['key'];
        }
    }

    /**
     * Return leftover stream context.
     *
     * @return mixed
     */
    public function getContents()
    {
        if (is_resource($this->stream)) {
            return stream_get_contents($this->stream);
        }
    }
}
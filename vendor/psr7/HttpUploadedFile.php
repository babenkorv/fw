<?php

namespace vendor\psr7;

use vendor\psr7\psr7interface\StreamInterface;
use vendor\psr7\psr7interface\UploadedFileInterface;

class HttpUploadedFile implements UploadedFileInterface
{
    private $clientFilename;
    private $clientMediaType;
    private $size;
    private $error;
    private $stream;
    private $file;

    /**
     * HttpUploadedFile constructor.
     *
     * @param string|resource $streamOrFile sting with link on file or resource.
     * @param int $size size file.
     * @param string $errorStatus string with error status.
     * @param string $clientFilename client file name.
     * @param string $clientMediaType  client media type.
     */
    public function __construct($streamOrFile, $size, $errorStatus, $clientFilename, $clientMediaType)
    {
        if(is_string($streamOrFile)) {
            $this->file = $streamOrFile;
        }
        if(is_resource($streamOrFile)) {
            $this->stream = $streamOrFile;
        }
        $this->error = $errorStatus;
        $this->clientFilename = $clientFilename;
        $this->clientMediaType = $clientMediaType;
    }

    /**
     * Move file to @param $targetPath.
     *
     * @param string $targetPath
     * @throws \Exception
     */
    public function moveTo($targetPath)
    {
        if(!is_string($targetPath)) {
            throw new \Exception('Target path must be a string');
        }
        if(empty($targetPath)) {
            throw new \Exception('Target path must be not empty');
        }

        $sapi = PHP_SAPI;

        if(empty($sapi) || strpos($sapi, 'cli') == 0 || !$this->file) {
            $this->writeFile($targetPath);
        } else {
            move_uploaded_file($this->file, $targetPath);
            $this->size = $_FILES[$this->file]['size'];
            $this->clientMediaType = $_FILES[$this->file]['type'];
        }
    }

    /**
     * Write file to @param $path.
     *
     * @param string $path path to
     * @throws \Exception
     */
    private function writeFile($path)
    {
        $handle = fopen($path, 'wb+');

        if (false === $handle) {
            $this->error = UPLOAD_ERR_CANT_WRITE;
            throw new \Exception('Error open file');
        }
        $sourceStream = new HttpStream($this->stream, 'r');
        $sourceStream->rewind();
        while (! $sourceStream->eof()) {
            fwrite($handle, $sourceStream->read(4096));
        }

        fclose($handle);

        $this->error = UPLOAD_ERR_OK;
    }

    /**
     * Return resource with file.
     * 
     * @return resource
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Return size of file.
     *
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Return error.
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Return client file name.
     *
     * @return string
     */
    public function getClientFilename()
    {
        return $this->clientFilename;
    }

    /**
     * Return media type.
     *
     * @return string
     */
    public function getClientMediaType()
    {
        return $this->clientMediaType;
    }
}
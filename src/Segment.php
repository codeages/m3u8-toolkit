<?php
namespace Codeages\M3U8Toolkit;

class Segment
{
    public $uri;

    public $duration;

    public $sequence;

    public $isDiscontinuity;

    public $keyUrl;
    
    public $iv;

    public function __construct($uri, $duration, $sequence, $isDiscontinuity = false, $keyUrl = null, $iv = null)
    {
        $this->uri = $uri;
        $this->duration = $duration;
        $this->sequence = $sequence;
        $this->isDiscontinuity = $isDiscontinuity;
        $this->keyUrl = $keyUrl;
        $this->iv = $iv;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getSequence()
    {
        return $this->sequence;
    }

    public function isDiscontinuity()
    {
        return $this->isDiscontinuity;
    }

    public function getKeyUrl()
    {
        return $this->keyUrl;
    }

    public function getIv()
    {
        return $this->iv;
    }

    public function setKey($url, $iv)
    {
        $this->keyUrl = $url;
        $this->iv = $iv;
    }
}

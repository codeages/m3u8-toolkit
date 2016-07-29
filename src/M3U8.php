<?php

namespace Codeages\M3U8Toolkit;

class M3U8
{
    private $playlist;
    private $version;
    private $targetDuration;
    private $discontinuitySequence;
    private $allowCache;
    private $hasEndlist;

    public function __construct(Playlist $playlist, $version, $targetDuration, $discontinuitySequence = null, $allowCache=false, $hasEndlist = false)
    {
        $this->playlist = $playlist;
        $this->version = $version;
        $this->targetDuration = $targetDuration;
        $this->discontinuitySequence = $discontinuitySequence;
        $this->allowCache = $allowCache;
        $this->hasEndlist = $hasEndlist;
    }

    public function getPlaylist()
    {
        return $this->playlist;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getTargetDuration()
    {
        return $this->targetDuration;
    }

    public function getMediaSequence()
    {
        return $this->playlist->getFirst()->getSequence();
    }

    public function getDiscontinuitySequence()
    {
        return $this->discontinuitySequence;
    }

    public function getAge()
    {
        return $this->playlist->getAge();
    }

    public function getDuration()
    {
        return $this->playlist->getDuration();
    }

    public function getAllowCache()
    {
        return $this->allowCache;
    }

    public function hasEndlist()
    {
        return $this->hasEndlist;
    }
}

<?php
namespace Codeages\M3U8Toolkit;

class Playlist implements \Iterator
{
    private $segments = array();
    private $age;
    private $position = 0;

    public function __construct(array $segments = array(), $age = null)
    {
        $this->segments = $segments;
        $this->age = $age;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->segments[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->segments[$this->position]);
    }

    public function add(Segment $segment)
    {
        $this->segments[] = $segment;

        return $this;
    }

    public function getFirst()
    {
        $first = reset($this->segments);

        if (false !== $first) {
            return $first;
        }
    }

    public function getDuration()
    {
        $duration = 0;
        foreach ($this->segments as $segment) {
            $duration += $segment->getDuration();
        }

        return $duration;
    }

    public function count()
    {
        return count($this->segments);
    }

    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }
}

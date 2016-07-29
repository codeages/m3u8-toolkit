<?php
namespace Codeages\M3U8Toolkit;

class Parser
{
    public function parse($content)
    {
        $data = $this->content2Data($content);

        $version = 3;
        $mediaSequence = 0;

        extract($data); // to $version, $mediaSequence, $targetDuration

        $playlist = new Playlist();
        foreach ($data['playlist'] as $index => $row) {
            $mediaSegment = new Segment(
                $row['uri'],
                $row['duration'],
                $mediaSequence + $index,
                !empty($row['isDiscontinuity'])
            );
            $playlist->add($mediaSegment);
        }

        return new M3U8($playlist, $version, $targetDuration, null, $allowCache, $hasEndlist);
    }

    private function content2Data($content)
    {
        $data = array();

        $mediaSequence = 0;

        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            if (preg_match('/^#EXT-X-VERSION:(\d+)/', $line, $matches)) {
                $data['version'] = $matches[1];
                continue;
            }

            if (preg_match('/^#EXT-X-TARGETDURATION:(\d+)/', $line, $matches)) {
                $data['targetDuration'] = +$matches[1];
                continue;
            }

            if (preg_match('/^#EXT-X-MEDIA-SEQUENCE:(\d+)/', $line, $matches)) {
                $data['mediaSequence'] = +$matches[1];
                continue;
            }

            if (preg_match('/^#EXT-X-ALLOW-CACHE:(.+)/', $line, $matches)) {
                $data['allowCache'] = strtoupper($matches[1]) === 'YES' ? true : false;
                continue;
            }

            if (preg_match('/^#EXT-X-DISCONTINUITY/', $line)) {
                $data['playlist'][$mediaSequence]['isDiscontinuity'] = true;
            }

            if (preg_match('/^#EXTINF:(.+),/', $line, $matches)) {
                $data['playlist'][$mediaSequence]['duration'] = +$matches[1];
                continue;
            }

            if (preg_match('/^#EXT-X-ENDLIST/', $line)) {
                $data['hasEndlist'] = true;
                break;
            }

            if (preg_match('/^[^#]+/', $line, $matches)) {
                $data['playlist'][$mediaSequence]['uri'] = $matches[0];
                ++$mediaSequence;
            }
        }

        return $data;
    }
}
<?php

namespace Codeages\M3U8Toolkit;

class Dumper
{
    public function dump(M3U8 $m3u8)
    {
        $lines = array(
            '#EXTM3U',
            sprintf('#EXT-X-VERSION:%s', $m3u8->getVersion()),
            sprintf('#EXT-X-TARGETDURATION:%d', $m3u8->getTargetDuration()),
        );

        if ($m3u8->getAllowCache()) {
            $lines[] = sprintf('#EXT-X-ALLOW-CACHE:YES');
        }

        if ($m3u8->getMediaSequence()) {
            $lines[] = sprintf('#EXT-X-MEDIA-SEQUENCE:%s', $m3u8->getMediaSequence());
        } else {
            $lines[] = sprintf('#EXT-X-MEDIA-SEQUENCE:%s', 0);
        }

        if ($m3u8->getDiscontinuitySequence()) {
            $lines[] = sprintf('#EXT-X-DISCONTINUITY-SEQUENCE:%s', $m3u8->getDiscontinuitySequence());
        }

        foreach ($m3u8->getPlaylist() as $segment) {
            if ($segment->isDiscontinuity()) {
                $lines[] = '#EXT-X-DISCONTINUITY';
            }

            if ($segment->keyUrl && $segment->iv) {
                $lines[] = sprintf('#EXT-X-KEY:METHOD=AES-128,URI="%s",IV=%s', $segment->keyUrl, $segment->iv);
            }

            $lines[] = $m3u8->getVersion() < 3 ? sprintf('#EXTINF:%d,', round($segment->getDuration())) : sprintf('#EXTINF:%.3f,', $segment->getDuration());
            $lines[] = $segment->getUri();
        }

        if ($m3u8->hasEndlist()) {
            $lines[] = '#EXT-X-ENDLIST';
        }

        return implode(PHP_EOL, $lines);
    }
}

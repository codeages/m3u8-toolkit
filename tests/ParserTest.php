<?php

namespace Codeages\M3U8Toolkit;

use Codeages\M3U8Toolkit\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $parser = new Parser();

        $data = file_get_contents(__DIR__ .'/Fixtures/test-1.m3u8');

        $m3u8 = $parser->parse($data);

        $dumper = new Dumper();

        $content = $dumper->dump($m3u8);

        var_dump($content);


    }

}
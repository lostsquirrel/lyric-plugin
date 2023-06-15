<?php

const HTTP_OK = 200;
class LyricSelf
{
    private $apiUrl = 'http://nas:18000';
    // private $apiUrl = 'http://192.168.10.10:8000';
    public function __construct()
    {
    }
    public function getLyricsList($artist, $title, $info)
    {
        $count = 0;
        $searchUrl = sprintf(
            "%s/search?artist=%s&song=%s",
            $this->apiUrl,
            urlencode($artist),
            urlencode($title)
        );
        $content = $this->getContent($searchUrl);
        $obj = json_decode($content, TRUE);
        if ($obj) {
            $downloadUrl = sprintf(
                "%s/lyric?id=%s",
                $this->apiUrl,
                urlencode($obj['id'])
            );
            $info->addTrackInfoToList(
                $obj['artist'],
                $obj['song'],
                $downloadUrl,
                $obj['id']
            );
            $count = 1;
        }
        return $count;
    }
    public function getLyrics($id, $info)
    {
        $lyric = $this->getLyricById($id);
        $info->addLyrics($lyric, $id);
        return true;
    }

    private function download($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        // echo $head;
        if ($httpCode == HTTP_OK) {
            return $head;
        }
        return "";
    }
    private function getContent($url)
    {
        $result = $this->download($url);
        // using curl to get content from url
        // echo "getContent\n";
        // echo $result;
        return $result;
    }
    private function getLyricById($id)
    {

        // using id to get lyric content
        // echo "xxx id" . $id;
        $lyric = $this->download($id);

        return $lyric;
    }
}

const DEBUG = false;
// echo DEBUG;
if (DEBUG) {
    class MockInfo
    {
        public function __construct()
        {
        }
        public function addTrackInfoToList($artist, $title, $id)
        {
            echo "\n";
            echo "addTrackInfoToList:\n";
            echo "artist: " . $artist;
            echo ", titile: " . $title;
            echo ", id: " . $id;
            echo "\n";
        }
        public function addLyrics($lyric, $id)
        {
            echo "addLyrics:\n";
            echo "lyric: " . $lyric;
            echo ", id: " . $id;
            echo "\n";
        }
    }
    $info = new MockInfo();
    $p = new LyricSelf();
    $artist = "Beyond";
    $title = "真的愛妳";
    echo "title: " . $title;
    $x = sprintf("%s - %s.lrc", $artist, $title);
    echo "xxxx:" . $x;
    $id = sprintf(
        "%s/lyric?id=%s",
        'http://192.168.10.10:8000',
        urlencode($x)
    );
    $count = $p->getLyricsList($artist, $title, $info);
    echo "count: " . $count . "\n";


    $lyric = $p->getLyrics($id, $info);
    echo "lyric: " . $lyric;
    echo "\ntest end\n";
}

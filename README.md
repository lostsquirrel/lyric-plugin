# lyric-plugin
self hosted lyric plugin for synology DS Audio

## test
docker run --rm -it -v $(pwd):/app --net host php:5.6-cli bash

## build
tar czf self-lyric.aum INFO lyric.php && mv self-lyric.aum ~/Downloads


## info

- name

The unique name of the lyrics module among all Audio Station
modules. The name must be one and only. If the name of the new
aum conflicts with that of the existing one, the newly-added aum
cannot be installed


## method

- getLyricsList
    $artist: string
    Artist name from the music info.
    $title: string
    Song title from the music info.
    $info: object
    The plugin class instance.
    Return value: integer
    Returns the number of results
    successfully parsed and added of the
    plugin.

- getLyrics

    $id: string
    Id from the search result.
    $info: object
    The plugin class instance.
    Return value: boolean
    Shows whether the lyrics are successfully
    retrieved or not.


## result

- $info -> addTrackInfoToList

$artist: string
Artist of the song
$title: string
Title of the song
$id: string
Id of the song will be passed to
getLyrics()later. Usually this id value would
be set as a URL of the lyrics page.
$partialLyrics: string
Optional. Some lyrics sites provide partial lyrics
for preview in the search result. This value will be
displayed when you search lyrics manually via
the Song information dialog


- $info
->
addLyrics

$lyric: string
Human readable text of lyrics.
$id: string
Song id passed from getLyrics()

## refer
- https://global.download.synology.com/download/Document/Software/DeveloperGuide/Package/AudioStation/All/enu/AS_Guide.pdf
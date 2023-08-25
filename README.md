# Subrip library
PHP library for parsing, modifying and composing SubRip (.srt) subtitles

## Usage

`$subrip = \SubRip\SubRip::fromFile('/dir/to/file/subtitle.srt');`

This will parse the `.srt` file into a SubRip entity. It is a `ArrayIterator` so you can use it like an array. It is also a `Stringable` so you can echo the object and it will output the entity as a string.

To export to a file use `$subrip->toFile('/path/to/file/subtitle.srt');` <br />
To output as string use `$subrip->toString();` <br />
To validate use `$subrip->validate();`

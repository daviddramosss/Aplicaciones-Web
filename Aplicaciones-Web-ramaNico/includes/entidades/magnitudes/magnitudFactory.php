<?php
namespace es\ucm\fdi\aw\entidades\magnitudes;

class MagnitudFactory {

    public static function create($id, $nombre) {
        return new MagnitudDTO($id, $nombre);
    }
}
?>

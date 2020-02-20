<?php

namespace Ajedrez\Piezas;

class PiezaNull implements Pieza {

    public function mover($x1, $y1, $x2, $y2, \Ajedrez\Tablero $tablero) {
        return false;
    }

    public function esBlanco() {
        return false;
    }
}
<?php

namespace Ajedrez\Piezas;

interface Pieza {
    public function mover($x1, $y1, $x2, $y2, \Ajedrez\Tablero $tablero);
    public function esBlanco();
}
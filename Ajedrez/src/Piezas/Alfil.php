<?php

namespace Ajedrez\Piezas;


class Alfil implements \Ajedrez\Piezas\Pieza {
    private $color;

    public function __construct($color) {
        $this->color = $color;
    }
    public function esBlanco() {
        return (bool) $this->color;
    }

    public function mover($x1, $y1, $x2, $y2, \Ajedrez\Tablero $tablero) {
        $diagonales = array(array(), array(), array(), array());
        for($i=1; $i < 8; $i++) {
            $diagonales[0][] = array($x1 + $i, $y1 + $i);
            $diagonales[1][] = array($x1 - $i, $y1 - $i);
            $diagonales[2][] = array($x1 - $i, $y1 + $i);
            $diagonales[3][] = array($x1 + $i, $y1 - $i);
        }
        foreach ($diagonales as $coordenadas) {
            if ($this->checkLine($coordenadas, $tablero, $x2, $y2)) {
                return true;
            }
        }
        return false;
    }

    private function checkLine($coordenadas, $tablero, $x2, $y2) {
        $coordenadas = $this->limpiarCoordenadas($coordenadas);
        if (in_array( array($x2, $y2), $coordenadas )) {
            foreach($coordenadas as $coord) {

                if ($coord != array($x2, $y2)) {
                    if (!($tablero->dame($coord[0], $coord[1]) instanceof \Ajedrez\Piezas\PiezaNull)) {
                        return false;
                    }
                }
                if ($coord == array($x2, $y2)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function limpiarCoordenadas(array $coordenadas) {
        $out = array();
        foreach($coordenadas as $coord) {
            if ($this->posValida($coord[0], $coord[1])) {
                $out[] = $coord;
            }
        }
        return $out;
    }

    private function posValida($x, $y) {
        if ($x < 0 || $y < 0) {
            return false;
        }
        if ($x > 7 || $y > 7) {
            return false;
        }
        return true;
    }
}
<?php

namespace Ajedrez;

use Ajedrez\Piezas\Pieza;
use Ajedrez\Piezas\PiezaNull;

class Tablero {
    private $tablero = array();

    public function __construct() {
        for($i=0; $i<8; $i++) {
            for($j=0; $j<8; $j++) {
                $this->tablero[$i][$j] = false;
            }
        }
    }

    public function colocarPieza($x, $y, Pieza $pieza) {
        if ($this->posicionValida($x, $y) and $this->dame($x, $y) instanceof \Ajedrez\Piezas\PiezaNull) {
            $this->tablero[$x][$y] = $pieza;
            return true;
        }
        return false;
    }

    public function dame($x, $y) {
        if (empty($this->tablero[$x][$y])) {
            return new \Ajedrez\Piezas\PiezaNull();
        }
        return $this->tablero[$x][$y];
    }

    public function mover($x1, $y1, $x2, $y2) {
        if (!$this->posicionValida($x1, $y1)
                || !$this->posicionValida($x2, $y2)) {
            return false;
        }
        if ($this->dame($x1, $y1) instanceof \Ajedrez\Piezas\PiezaNull) {
            return false;
        }
        $pieza = $this->dame($x1, $y1);
        $otraPieza = $this->dame($x2, $y2);
        if (!($otraPieza instanceof \Ajedrez\Piezas\PiezaNull) and
                $pieza->esBlanco() === $otraPieza->esBlanco()) { 
            return false;
        }

        if ($pieza->mover($x1, $y1, $x2, $y2, $this)) {
            $this->tablero[$x2][$y2] = $this->tablero[$x1][$y1];
            $this->tablero[$x1][$y1] = false;
            return true;
        }
        
        return false;
    }

    private function posicionValida($x, $y) {
        if ($x < 0 || $y < 0) {
            return false;
        }
        if ($x > 7 || $y > 7) {
            return false;
        }
        return true;
    }
}
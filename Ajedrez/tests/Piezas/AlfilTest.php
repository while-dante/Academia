<?php


namespace AjedrezTests\Piezas;

class AlfilTest extends \PHPUnit\Framework\TestCase {

    protected function setUp(): void {
        $this->tablero = new \Ajedrez\Tablero();
        $this->alfil = new \Ajedrez\Piezas\Alfil(true);
        $this->alfilNegro = new \Ajedrez\Piezas\Alfil(false);
    }
    public function testColocoAlfil() {
        $res = $this->tablero->colocarPieza(2,3, $this->alfil);
        $res2 = $this->tablero->colocarPieza(2,3, $this->alfilNegro);
        $this->assertTrue($res);
        $this->assertFalse($res2);
    }
    
    public function testMoverUnLugar() {
        $this->tablero->colocarPieza(2, 3, $this->alfil);
        $res = $this->tablero->mover(2, 3, 3, 4);
        $this->assertTrue($res);
    }
    
    public function testMoverVariosLugares() {
        $this->tablero->colocarPieza(2, 3, $this->alfil);
        $res = $this->tablero->mover(2, 3, 6, 7);
        $this->assertTrue($res);
        $this->assertTrue($this->tablero->dame(2,3) instanceof \Ajedrez\Piezas\PiezaNull);
        $this->assertTrue($this->tablero->dame(6,7) instanceof \Ajedrez\Piezas\Alfil);
    }
    
    public function testMoverVariosLugaresYLoMuevoParaAtras() {
        $this->tablero->colocarPieza(2, 3, $this->alfil);
        $res = $this->tablero->mover(2, 3, 6, 7);
        $this->assertTrue($res);
        $this->assertTrue($this->alfil->mover(2,3, 6,7, $this->tablero));

        $this->assertTrue($this->tablero->dame(2,3) instanceof \Ajedrez\Piezas\PiezaNull);
        $this->assertTrue($this->tablero->dame(6,7) instanceof \Ajedrez\Piezas\Alfil);
        $res = $this->tablero->mover(6, 7, 2, 3);
        $this->assertTrue($res);
        $this->assertTrue($this->tablero->dame(2,3) instanceof \Ajedrez\Piezas\Alfil);
        $this->assertTrue($this->tablero->dame(6,7) instanceof \Ajedrez\Piezas\PiezaNull);
    }

    public function testMoverYHayUnoEnElMedio() {
        $this->tablero->colocarPieza(2, 3, $this->alfil);
        $this->tablero->colocarPieza(5, 6, $this->alfilNegro);
        $res = $this->tablero->mover(2, 3, 6, 7);
        $this->assertFalse($res);
        $this->assertTrue($this->tablero->dame(2,3) instanceof \Ajedrez\Piezas\Alfil);
        $this->assertTrue($this->tablero->dame(6,7) instanceof \Ajedrez\Piezas\PiezaNull);
    }

    public function testMoverYComer() {
        $this->tablero->colocarPieza(2, 3, $this->alfil);
        $this->tablero->colocarPieza(5, 6, $this->alfilNegro);
        $res = $this->tablero->mover(2, 3, 5, 6);
        $this->assertTrue($res);
        $this->assertTrue($this->tablero->dame(2,3) instanceof \Ajedrez\Piezas\PiezaNull);
        $this->assertTrue($this->tablero->dame(5,6) instanceof \Ajedrez\Piezas\Alfil);
    }
}
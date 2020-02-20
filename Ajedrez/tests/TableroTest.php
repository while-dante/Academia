<?php

namespace AjedrezTests;

class TableroTest extends \PHPUnit\Framework\TestCase {

    protected function setUp(): void {
        $this->tablero = new \Ajedrez\Tablero();
    }

    public function testMeDaNull() {
        $this->assertTrue($this->tablero->dame(1,2) instanceof \Ajedrez\Piezas\PiezaNull);
    }

    public function testColocarPieza() {
        $piezaNull = new \Ajedrez\Piezas\PiezaNull();
        $this->assertTrue($this->tablero->colocarPieza(0,0, $piezaNull));
        $this->assertFalse($this->tablero->colocarPieza(9,8, $piezaNull));
    }
}
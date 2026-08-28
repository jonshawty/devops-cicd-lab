<?php

use App\Calculadora;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Calculadora.php';

class CalculadoraTest extends TestCase
{
    public function testSomar(): void
    {
        $calculadora = new Calculadora();

        $resultado = $calculadora->somar(2, 3);

        $this->assertEquals(5, $resultado);
    }

    public function testSubtrair(): void
    {
        $calculadora = new Calculadora();

        $resultado = $calculadora->subtrair(5, 3);

        $this->assertEquals(2, $resultado);
    }
}
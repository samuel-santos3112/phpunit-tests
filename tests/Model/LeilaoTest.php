<?php

namespace App\Tests\Model;

use App\Model\Lance;
use App\Model\Leilao;
use App\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(
        $qtdLances,
        Leilao $leilao,
        array $valores
    ) {

        self::assertCount($qtdLances, $leilao->getLances());
        foreach ($valores as $i => $valorEsperado) {
            self::assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
        }
    }

    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        $ana = new Usuario('Ana');

        $lance1 = new Lance($ana, 1500);
        $lance2 = new Lance($ana, 1600);

        $leilao = new Leilao('Leilão Teste');
        $leilao->recebeLance($lance1);
        $leilao->recebeLance($lance2);

        self::assertCount(1, $leilao->getLances());
        self::assertEquals(1500, $leilao->getLances()[0]->getValor());
    }

    public function testLeilaoNaoDeveAceitarMaisDe5LancesPorUsuario()
    {
        $leilao = new Leilao('Brasília Amarela');
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');

        $lance1 = new Lance($joao, 1500);
        $lance2 = new Lance($maria, 1800);
        $lance3 = new Lance($joao, 2500);
        $lance4 = new Lance($maria, 2800);
        $lance5 = new Lance($joao, 3500);
        $lance6 = new Lance($maria, 3800);
        $lance7 = new Lance($joao, 4500);
        $lance8 = new Lance($maria, 4800);
        $lance9 = new Lance($joao, 5500);
        $lance10 = new Lance($maria, 5800);
        $lance11 = new Lance($joao, 6500);

        $leilao->recebeLance($lance1);
        $leilao->recebeLance($lance2);
        $leilao->recebeLance($lance3);
        $leilao->recebeLance($lance4);
        $leilao->recebeLance($lance5);
        $leilao->recebeLance($lance6);
        $leilao->recebeLance($lance7);
        $leilao->recebeLance($lance8);
        $leilao->recebeLance($lance9);
        $leilao->recebeLance($lance10);
        $leilao->recebeLance($lance11);


        self::assertCount(10, $leilao->getLances());
        self::assertEquals(5800, $leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
    }

    public function geraLances()
    {
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');

        $lance1 = new Lance($joao, 1500);
        $lance2 = new Lance($maria, 1800);

        $leilaoCom2Lances = new Leilao('Leilão Teste');
        $leilaoCom2Lances->recebeLance($lance1);
        $leilaoCom2Lances->recebeLance($lance2);

        $leilaoCom1Lance = new Leilao('Leilão Teste 2');
        $leilaoCom1Lance->recebeLance($lance1);

        return [
            [2, $leilaoCom2Lances, [1500, 1800]],
            [1, $leilaoCom1Lance, [1500]]
        ];
    }

}

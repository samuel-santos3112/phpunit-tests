<?php

namespace App\Tests\Service;

use App\Model\Enum\TipoAvaliacao;
use App\Model\Lance;
use App\Model\Leilao;
use App\Model\Usuario;
use App\Service\Avaliador;
use PHPUnit\Framework\TestCase;


class AvaliadorTest extends TestCase
{
    private $leiloeiro;

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public function testEncontraMaiorValorDeLances(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao, TipoAvaliacao::MAIOR);

        $valorEsperado = 146.9;

        self::assertEquals($valorEsperado, $this->leiloeiro->getMaiorValor());
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public function testEncontraMenorValorDeLances(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao, TipoAvaliacao::MENOR);

        $valorEsperado = 122.9;

        self::assertEquals($valorEsperado, $this->leiloeiro->getMenorValor());
    }

    /**
     * @dataProvider leilaoEmOrdemAleatoria
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     */
    public function testEncontrarTresMaioresLances(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao, TipoAvaliacao::TRESMAIORES);

        $tresMaioresValores = $this->leiloeiro->getTresMaioresLances();

        self::assertEquals(146.9, $tresMaioresValores[0]->getValor());
        self::assertEquals(135.9, $tresMaioresValores[1]->getValor());
        self::assertEquals(128.9, $tresMaioresValores[2]->getValor());
        self::assertCount(3, $tresMaioresValores);
    }

    public function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Leilão 1');

        $usr1 = new Usuario('Samuel');
        $usr2 = new Usuario('Max');
        $usr3 = new Usuario('Jeferson');

        $lance1 = new Lance($usr3,122.9);
        $lance2 = new Lance($usr2,125.9);
        $lance3 = new Lance($usr3,128.9);
        $lance4 = new Lance($usr1,135.9);
        $lance5 = new Lance($usr2,146.9);

        $leilao->recebeLance($lance1);
        $leilao->recebeLance($lance2);
        $leilao->recebeLance($lance3);
        $leilao->recebeLance($lance4);
        $leilao->recebeLance($lance5);

        return [
            [$leilao]
        ];
    }

    public function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Leilão 1');

        $usr1 = new Usuario('Samuel');
        $usr2 = new Usuario('Max');
        $usr3 = new Usuario('Jeferson');

        $lance1 = new Lance($usr3,146.9);
        $lance2 = new Lance($usr2,135.9);
        $lance3 = new Lance($usr1,128.9);
        $lance4 = new Lance($usr2,125.9);
        $lance5 = new Lance($usr3,122.9);

        $leilao->recebeLance($lance1);
        $leilao->recebeLance($lance2);
        $leilao->recebeLance($lance3);
        $leilao->recebeLance($lance4);
        $leilao->recebeLance($lance5);

        return [
            [$leilao]
        ];
    }

    public function leilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Leilão 1');

        $usr1 = new Usuario('Samuel');
        $usr2 = new Usuario('Max');
        $usr3 = new Usuario('Jeferson');

        $lance1 = new Lance($usr3,146.9);
        $lance2 = new Lance($usr1, 125.9);
        $lance3 = new Lance($usr3,128.9);
        $lance4 = new Lance($usr2, 135.9);
        $lance5 = new Lance($usr1,122.9);

        $leilao->recebeLance($lance1);
        $leilao->recebeLance($lance2);
        $leilao->recebeLance($lance3);
        $leilao->recebeLance($lance4);
        $leilao->recebeLance($lance5);

        return [
            [$leilao]
        ];
    }

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }
}


<?php

namespace App\Service;

use App\Model\Enum\TipoAvaliacao;
use App\Model\Lance;
use App\Model\Leilao;
use SplFixedArray;

class Avaliador
{
    /**
     * @var float
     */
    private $maiorValor = -INF;

    /**
     * @var float
     */
    private $menorValor = INF;

    /**
     * @var Lance[]
     */
    private $arrMaioresLances;

    /**
     * @param Leilao $leilao
     */
    public function avalia(Leilao $leilao, $avaliacao) : void
    {
        $lances = $leilao->getLances();
        if  ($avaliacao == 1) {
            foreach ($lances as $lance) {
                if ($lance->getValor() < $this->getMenorValor()) {
                    $this->menorValor = $lance->getValor();
                }
            }
        } elseif ($avaliacao == 2) {
            foreach ($lances as $lance) {
                if ($lance->getValor() > $this->getMaiorValor()) {
                    $this->maiorValor = $lance->getValor();
                }
            }
        } elseif ($avaliacao == 3) {
            usort($lances, function (Lance $lance1, Lance $lance2) {
                return $lance2->getValor() - $lance1->getValor();
            });

            $this->arrMaioresLances = array_slice($lances, 0, 3);
        }
    }

    /**
     * @return Lance[]
     */
    public function getTresMaioresLances(): array
    {
        return $this->arrMaioresLances;
    }

    /**
     * @return float
     */
    public function getMenorValor() : float
    {
        return $this->menorValor;
    }

    /**
     * @return mixed
     */
    public function getMaiorValor() : float
    {
        return $this->maiorValor;
    }
}
<?php

namespace App\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty($this->lances) && $this->mesmoUsuarioDoUltimoLance($lance)) {
            return;
        }

        $usuarioAtual = $lance->getUsuario();
        $totalLancesUsuario = array_reduce(
            $this->lances,
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuarioAtual) {
                $lanceAtual->getUsuario() == $usuarioAtual ? $totalAcumulado++ : false;
                return $totalAcumulado;
            },
            0
        );

        if ($totalLancesUsuario >= 5) {
            return;
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    /**
     * @param Lance $lance
     * @return bool
     */
    private function mesmoUsuarioDoUltimoLance(Lance $lance): bool
    {
        $ultimoLance = $this->lances[array_key_last($this->lances)];
        return $lance->getUsuario() == $ultimoLance->getUsuario();
    }
}

<?php

class Revir
{
    private int $cisloReviru;
    private string $popis;
    public function __construct(int $cisloReviru, string $popis)
    {
        $this ->cisloReviru= $cisloReviru;
        $this ->popis= $popis;
    }
    public function getCisloReviru(): int
    {
        return $this->cisloReviru;
    }
    public function setCisloReviru(int $cisloReviru): void
    {
        $this->cisloReviru = $cisloReviru;
    }
    public function getPopis(): string
    {
        return $this->popis;
    }
    public function setPopis(string $popis): void
    {
        $this->popis = $popis;
    }
}
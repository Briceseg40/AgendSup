<?php


class Classe
{
    private int|null $id;
    private int|null $TD;
    private int|null $TP;
 
    public function __construct(?int $id = null, ?int $TD = null, ?int $TP = null)
    {
        $this->setId($id);
        $this->setTd($TD);
        $this->setTp($TP);

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTd(): ?int
    {
        return $this->TD;
    }

    public function setTd(?string $TD): void
    {
        $this->TD = $TD;
    }

    public function getTp(): ?int
    {
        return $this->TP;
    }

    public function setTp(?string $TP): void
    {
        $this->TP = $TP;
    }
    
}

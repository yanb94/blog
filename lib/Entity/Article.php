<?php

namespace Framework\Entity;

class Article extends Entity
{
    protected $titre;
    protected $chapo;
    protected $contenu;
    protected $author;
    protected $updatedAt;

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setTitre(string $titre)
    {
        $this->titre = $titre;
    }

    public function getChapo(): string
    {
        return $this->chapo;
    }

    public function setChapo(string $chapo)
    {
        $this->chapo = $chapo;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu)
    {
        $this->contenu = $contenu;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $date)
    {
        $this->updatedAt = $date;
    }
}

<?php

namespace Framework\Entity;

use Framework\Entity;

class Article extends Entity
{
    protected $titre;
    protected $chapo;
    protected $contenu;
    protected $author;
    protected $updatedAt;

    protected $authorName;

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre(string $titre)
    {
        $this->titre = $titre;
    }

    public function getChapo()
    {
        return $this->chapo;
    }

    public function setChapo(string $chapo)
    {
        $this->chapo = $chapo;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu)
    {
        $this->contenu = $contenu;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(int $author)
    {
        $this->author = $author;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName)
    {
        $this->authorName = $authorName;
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

<?php

namespace Framework\Entity;

use Framework\Entity;

class Comment extends Entity
{
    protected $contenu;
    protected $createdAt;
    protected $author;
    protected $article;
    protected $validate;

    protected $authorName;
    protected $articleName;

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu)
    {
        $this->contenu = $contenu;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $date)
    {
        $this->createdAt = $date;
    }

    public function getAuthor(): int
    {
        return $this->author;
    }

    public function setAuthor(int $author)
    {
        $this->author = $author;
    }

    public function getArticle(): int
    {
        return $this->article;
    }

    public function setArticle(string $article)
    {
        $this->article = $article;
    }

    public function getValidate(): bool
    {
        return $this->validate;
    }

    public function setValidate(bool $validate)
    {
        $this->validate = $validate;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName)
    {
        $this->authorName = $authorName;
    }

    public function getArticleName(): int
    {
        return $this->articleName;
    }

    public function setArticleName(string $articleName)
    {
        $this->articleName = $articleName;
    }
}

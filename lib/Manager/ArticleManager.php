<?php

namespace Framework\Manager;

use Framework\Manager;
use Framework\Entity\Article;

class ArticleManager extends Manager
{
    public function add(Article $article)
    {
        $dateNow = (new \DateTime('now'))->format('Y-m-d H:i:s');

        $req = $this->dao->prepare("
            INSERT INTO 
                article 
            SET 
                titre = :titre,
                chapo = :chapo,
                contenu = :contenu,
                author = :author,
                updatedAt = :updatedAt
            ");

        $req->bindValue(':titre', $article->getTitre());
        $req->bindValue(':chapo', $article->getChapo());
        $req->bindValue(':contenu', $article->getContenu());
        $req->bindValue(':author', $article->getAuthor(), \PDO::PARAM_INT);
        $req->bindValue(':updatedAt', $dateNow);

        $req->execute();

        $article->setId($this->dao->lastInsertId());
    }

    public function get(int $id)
    {
        $req = $this->dao->prepare("
            SELECT
                article.id,
                article.titre,
                article.chapo,
                article.contenu, 
                article.author,
                article.updatedAt,
                member.login AS authorName
            FROM article 
            LEFT JOIN member ON article.author = member.id
            WHERE article.id = :id ");

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Article::class);

        return $req->fetch();
    }

    public function delete(int $id)
    {
        $req = $this->dao->prepare("
            DELETE FROM
                article 
            WHERE 
                id = :id
            ");

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();
    }

    public function edit(Article $article)
    {
        $dateNow = (new \DateTime('now'))->format('Y-m-d H:i:s');

        $req = $this->dao->prepare("
            UPDATE 
                article 
            SET 
                titre = :titre,
                chapo = :chapo,
                contenu = :contenu,
                updatedAt = :updatedAt,
                author = :author
            WHERE 
                id = :id
            ");

        $req->bindValue(':id', $article->getId());
        $req->bindValue(':titre', $article->getTitre());
        $req->bindValue(':chapo', $article->getChapo());
        $req->bindValue(':contenu', $article->getContenu());
        $req->bindValue(':updatedAt', $dateNow);
        $req->bindValue(':author', $article->getAuthor());

        $req->execute();
    }

    public function getList(int $page, $pagination)
    {
        $start = ($page-1)*$pagination;

        $req = $this->dao->prepare("
            SELECT 
                article.id,
                article.titre,
                article.chapo,
                article.contenu,
                article.author,
                article.updatedAt,
                member.login AS authorName
            FROM article
            LEFT JOIN 
                member
                ON article.author = member.id
            ORDER BY article.id DESC
            LIMIT :start, :pagination ");

        $req->bindValue(':start', (int)$start, \PDO::PARAM_INT);
        $req->bindValue(':pagination', (int)$pagination, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Article::class);

        return $req->fetchAll();
    }

    public function getAll()
    {
        $req = $this->dao->prepare("
            SELECT 
                article.id,
                article.titre,
                article.chapo,
                article.contenu,
                article.author,
                article.updatedAt,
                member.login AS authorName
            FROM article
            LEFT JOIN 
                member
                ON article.author = member.id
            ORDER BY article.id DESC");

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Article::class);

        return $req->fetchAll();
    }

    public function count()
    {
        return $this->dao->query("
            SELECT 
                COUNT(*)
            FROM 
                article
            ")->fetchColumn();
    }
}

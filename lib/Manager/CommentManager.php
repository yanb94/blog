<?php

namespace Framework\Manager;

use Framework\Manager;
use Framework\Entity\Comment;

class CommentManager extends Manager
{
    public function add(Comment $comment)
    {
        $dateNow = new \DateTime('now');

        $req = $this->dao->prepare("
            INSERT INTO
                comment
            SET
                contenu = :contenu,
                createdAt = :createdAt,
                author = :author,
                article = :article,
                validate = :validate
            ");

        $req->bindValue(':contenu', $comment->getContenu());
        $req->bindValue(':createdAt', $dateNow);
        $req->bindValue(':author', $comment->getAuthor(), \PDO::PARAM_INT);
        $req->bindValue(':article', $comment->getArticle(), \PDO::PARAM_INT);
        $red->bindValue(':validate', $comment->getValidate());

        $req->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    public function get(int $id): Comment
    {
        $req = $this->dao->prepare("
            SELECT 
                id,
                contenu,
                createdAt,
                author,
                article,
                validate, 
                member.login AS authorName,
                article.titre AS articleName
            FROM 
                comment
            WHERE 
                id = :id
            LEFT JOIN 
                member 
                ON 
                    comment.author = member.id 
            LEFT JOIN 
                article 
                ON 
                    comment.article = article.id");

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Comment::class);

        return $req->fetch();
    }

    public function getListOf(int $articleId)
    {
        $req = $this->dao->prepare("
            SELECT 
                id,
                contenu,
                createdAt,
                author,
                member.login AS authorName,
                article.titre AS articleName
            FROM 
                comment 
            WHERE 
                article = :article 
                AND 
                validate = :validate 
            LEFT JOIN 
                member
                ON 
                    comment.author = member.id 
            LEFT JOIN 
                article 
                ON
                    comment.article = article.id");

        $req->bindValue(':article', $articleId, \PDO::PARAM_INT);
        $req->bindValue(':validate', true);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Comment::class);

        return $req->fetchAll();
    }

    public function getNoValidate()
    {
        $req = $this->dao->prepare("
            SELECT 
                id,
                contenu,
                createdAt,
                author,
                article,
                member.login AS authorName,
                article.titre AS articleName 
            FROM 
                comment
            WHERE 
                validate = :validate
            LEFT JOIN 
                member 
                ON 
                    comment.author = member.id
            LEFT JOIN 
                article 
                ON
                    comment.article = article.id");

        $req->bindValue(':article', $articleId, \PDO::PARAM_INT);
        $req->bindValue(':validate', false);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Comment::class);

        return $req->fetchAll();
    }

    public function delete(int $id)
    {
        $req = $this->dao->prepare("
            DELETE FROM
                comment
            WHERE 
                id = :id
            ");
        $red->bindValue(':id', $comment->getId());

        $req->execute();
    }

    public function edit(Comment $comment)
    {
        $req = $this->dao->prepare("
            UPDATE 
                comment 
            SET
                contenu = :contenu,
                createdAt = :createdAt,
                author = :author,
                article = :article,
                validate = :validate
                WHERE 
                    id = :id
            ");

        $req->bindValue(':contenu', $comment->getContenu());
        $req->bindValue(':createdAt', $comment->getCreatedAt());
        $req->bindValue(':author', $comment->getAuthor(), \PDO::PARAM_INT);
        $req->bindValue(':article', $comment->getArticle(), \PDO::PARAM_INT);
        $red->bindValue(':validate', $comment->getValidate());
        $red->bindValue(':id', $comment->getId());

        $req->execute();
    }
}

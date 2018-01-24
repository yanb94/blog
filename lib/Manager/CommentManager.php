<?php

namespace Framework\Manager;

use Framework\Manager;
use Framework\Entity\Comment;

class CommentManager extends Manager
{
    public function add(Comment $comment)
    {
        $dateNow = (new \DateTime('now'))->format('Y-m-d H:i:s');

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
        $req->bindValue(':createdAt', (string)$dateNow);
        $req->bindValue(':author', $comment->getAuthor(), \PDO::PARAM_INT);
        $req->bindValue(':article', $comment->getArticle(), \PDO::PARAM_INT);
        $req->bindValue(':validate', $comment->getValidate(), \PDO::PARAM_BOOL);

        $req->execute();

        $comment->setId($this->dao->lastInsertId());
    }

    public function get(int $id): Comment
    {
        $req = $this->dao->prepare("
            SELECT 
                comment.id,
                comment.contenu,
                comment.createdAt,
                comment.author,
                comment.article,
                comment.validate, 
                member.login AS authorName,
                article.titre AS articleName
            FROM 
                comment

            LEFT JOIN 
                member 
                ON 
                    comment.author = member.id 
            LEFT JOIN 
                article 
                ON 
                    comment.article = article.id
            WHERE 
                comment.id = :id
                    ");

        $req->bindValue(':id', $id, \PDO::PARAM_INT);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Comment::class);

        return $req->fetch();
    }

    public function getListOf(int $articleId)
    {
        $req = $this->dao->prepare("
            SELECT 
                comment.id,
                comment.contenu,
                comment.createdAt,
                comment.author,
                member.login AS authorName,
                article.titre AS articleName
            FROM 
                comment 

            LEFT JOIN 
                member
                ON 
                    comment.author = member.id 
            LEFT JOIN 
                article 
                ON
                    comment.article = article.id
            WHERE 
                comment.article = :article 
                AND 
                comment.validate = :validate
            ORDER BY comment.createdAt DESC
            ");

        $req->bindValue(':article', $articleId, \PDO::PARAM_INT);
        $req->bindValue(':validate', true, \PDO::PARAM_BOOL);

        $req->execute();

        $req->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Comment::class);

        return $req->fetchAll();
    }

    public function getNoValidate()
    {
        $req = $this->dao->prepare("
            SELECT 
                comment.id,
                comment.contenu,
                comment.createdAt,
                comment.author,
                comment.article,
                member.login AS authorName,
                article.titre AS articleName 
            FROM 
                comment
            LEFT JOIN 
                member 
                ON 
                    comment.author = member.id
            LEFT JOIN 
                article 
                ON
                    comment.article = article.id
            WHERE 
                comment.validate = :validate
                ");

        $req->bindValue(':validate', false, \PDO::PARAM_BOOL);

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
        $req->bindValue(':id', $id);

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
        $req->bindValue(':validate', $comment->getValidate(), \PDO::PARAM_BOOL);
        $req->bindValue(':id', $comment->getId(), \PDO::PARAM_INT);

        $req->execute();
    }
}

<?php

namespace Application\AdminModule\Controller;

use Framework\Controller;

use Framework\Response;
use Framework\Response\RedirectResponse;
use Framework\Entity\Article;

use Framework\FormBuilder\ArticleFormBuilder;
use Framework\FormBuilder\EditArticleFormBuilder;

class AdminController extends Controller
{
    public function adminHome():Response
    {
        $articles = $this->managers->getManagerOf('Article')->getAll();
        $comments = $this->managers->getManagerOf('Comment')->getNoValidate();
        $members = $this->managers->getManagerOf('Member')->getByValidate(true);

        return $this->render('@admin/adminHome.html.twig', [
            'articles'=> $articles,
            'comments' => $comments,
            'members' => $members
        ]);
    }

    public function addBlog():Response
    {
        $user = $this->app->getUser();
        $request = $this->getApp()->getRequest();
        
        if ($request->method() == 'POST'
            && $request->postExists(ArticleFormBuilder::NAME_FORM)
            && $request->postData(ArticleFormBuilder::NAME_FORM)['crsf_token'] == $user->getCrsfToken()) {
            $article = new Article($request->postData(ArticleFormBuilder::NAME_FORM));
            $article->setAuthor($user->getMember()->getId());
            $formBuilder = new ArticleFormBuilder($article, $user->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();

            if ($form->isValid()) {
                try {
                    $this->managers->getManagerOf('Article')->add($article);
                    $url = $this->app->getRouter()->generateUrl('adminHome');
                    return $this->redirect($url);
                } catch (\PDOException $e) {
                    $user->setFlash("Une erreur s'est produite lors de l'enregistrement de l'article en base de donné");
                }
            }
        } else {
            $article = new Article();
            $formBuilder = new ArticleFormBuilder($article, $user->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();
        }


        return $this->render('@admin/addBlog.html.twig', ['form'=>$form->createView()]);
    }

    public function editBlog(array $params):Response
    {
        $user = $this->app->getUser();
        $article = $this->managers->getManagerOf('Article')->get($params['id']);
        $members = $this->managers->getManagerOf('Member')->getByValidate(true);
        $request = $this->getApp()->getRequest();

        if ($request->method() == 'POST'
            && $request->postExists(EditArticleFormBuilder::NAME_FORM)
            && $request->postData(EditArticleFormBuilder::NAME_FORM)['crsf_token'] == $user->getCrsfToken()) {
            $article->hydrate($request->postData(EditArticleFormBuilder::NAME_FORM));

            $formBuilder = new EditArticleFormBuilder($article, $user->getCrsfToken(), $members);
            $formBuilder->build();

            $form = $formBuilder->getForm();

            if ($form->isValid()) {
                try {
                    $this->managers->getManagerOf('Article')->edit($article);
                    $url = $this->app->getRouter()->generateUrl('editBlog', ['id' => $article->getId()]);
                    $user->setFlash(['article_success'=> "Les modifications ont bien été enregistré"]);
                    return $this->redirect($url);
                } catch (\PDOException $e) {
                    $user->setFlash(['article_error'=>
                        "Une erreur s'est produite lors de l'enregistrement en base de donné"]);
                }
            }
        } else {
            $formBuilder = new EditArticleFormBuilder($article, $user->getCrsfToken(), $members);
            $formBuilder->build();

            $form = $formBuilder->getForm();
        }

        return $this->render('@admin/editBlog.html.twig', [
            'form'=> $form->createView(),
            'article' => $article
        ]);
    }

    public function removeBlog(array $params):RedirectResponse
    {
        try {
            $this->managers->getManagerOf('Article')->delete($params['id']);
            $this->app->getUser()->setFlash([
                'blog_success'=> "L'article à été supprimé avec succès"
            ]);
        } catch (\PDOException $e) {
            $this->app->getUser()->setFlash([
                'blog_error'=> "Suite à un problème la suppression n'a pas fonctionné"
            ]);
        }

        $url = $this->app->getRouter()->generateUrl('adminHome');
        return $this->redirect($url.'#list-article');
    }

    public function validateComment(array $params):RedirectResponse
    {
        try {
            $comment = $this->managers->getManagerOf('Comment')->get($params['id']);
            $comment->setValidate(true);
            $this->managers->getManagerOf('Comment')->edit($comment);

            $this->app->getUser()->setFlash([
                'comment_success'=> "Le commentaire à bien été validé"
            ]);
        } catch (\PDOException $e) {
            $this->app->getUser()->setFlash([
                'comment_error'=> "Suite à une erreur le commentaire n'a pas été validé"
            ]);
        }


        $url = $this->app->getRouter()->generateUrl('adminHome');
        return $this->redirect($url.'#list-comment');
    }

    public function deleteComment(array $params):RedirectResponse
    {
        try {
            $this->managers->getManagerOf('Comment')->delete($params['id']);
            $this->app->getUser()->setFlash([
                'comment_success'=> "Le commentaire à bien été supprimé"
            ]);
        } catch (\PDOException $e) {
            $this->app->getUser()->setFlash([
                'comment_error'=> "Suite à une erreur le commentaire n'a pas été supprimé"
            ]);
        }

        $url = $this->app->getRouter()->generateUrl('adminHome');
        return $this->redirect($url.'#list-comment');
    }

    public function giveMemberAdmin(array $params): RedirectResponse
    {
        try {
            $member = $this->managers->getManagerOf('Member')->get($params['id']);
            $member->setRole('ROLE_ADMIN');
            $this->managers->getManagerOf('Member')->edit($member);

            $this->app->getUser()->setFlash([
                'member_success'=> "Les droits administrateurs ont bien été attribué"
            ]);
        } catch (\PDOException $e) {
            $this->app->getUser()->setFlash([
                'member_error'=> "Suite à une erreur les droits administrateurs n'ont pas été attribué"
            ]);
        }

        $url = $this->app->getRouter()->generateUrl('adminHome');
        return $this->redirect($url.'#list-member');
    }

    public function removeMemberAdmin(array $params): RedirectResponse
    {
        try {
            $member = $this->managers->getManagerOf('Member')->get($params['id']);
            $member->setRole('ROLE_USER');
            $this->managers->getManagerOf('Member')->edit($member);

            $this->app->getUser()->setFlash([
                'member_success'=> "Les droits administrateurs ont bien été retiré"
            ]);
        } catch (\PDOException $e) {
            $this->app->getUser()->setFlash([
                'member_error'=> "Suite à une erreur les droits administrateurs n'ont pas été retiré"
            ]);
        }

        $url = $this->app->getRouter()->generateUrl('adminHome');
        return $this->redirect($url.'#list-member');
    }
}

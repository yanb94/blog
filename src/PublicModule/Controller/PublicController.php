<?php

namespace Application\PublicModule\Controller;

use Framework\Controller;
use Framework\Response;
use Framework\Response\HTMLResponse;
use Framework\Response\RedirectResponse;

use Framework\Entity\Comment;
use Framework\FormBuilder\CommentFormBuilder;

class PublicController extends Controller
{
    public function home(): HTMLResponse
    {
        return $this->render("@public/home.html.twig");
    }

    public function listBlog(array $params): HTMLResponse
    {
        $pagination = 15;

        $articles = $this->managers->getManagerOf('Article')->getList($params['page'], $pagination);

        $nb = $this->managers->getManagerOf('Article')->count();

        $nbPage = ceil($nb/$pagination);

        return $this->render("@public/listBlog.html.twig", [
            'articles'=> $articles,
            'page'=> $params['page'],
            'nbPage' => $nbPage
        ]);
    }

    public function articleOne(array $params): Response
    {
        $request = $this->getApp()->getRequest();
        $user = $this->getApp()->getUser();


        if ($user->isGranted('ROLE_USER')
            and $request->method() == 'POST'
            and $request->postExists(CommentFormBuilder::NAME_FORM)
            and $request->postData(CommentFormBuilder::NAME_FORM)['crsf_token'] == $user->getCrsfToken()) {
            $comment = new Comment($request->postData(CommentFormBuilder::NAME_FORM));
            $comment->setArticle($params['id']);
            $comment->setAuthor($user->getMember()->getId());


            $formBuilder = new CommentFormBuilder($comment, $user->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();

            if ($form->isValid()) {
                $this->managers->getManagerOf('Comment')->add($comment);
                
                $url = $this->app->getRouter()->generateUrl('articleOne', ['id'=>$params['id']]);

                $user->setFlash("
                    L'ajout de votre commentaire à bien été prise en compte. Un administrateur doit maintenant le validé
                ");

                return $this->redirect($url);
            }
        } else {
            $comment = new Comment();

            $formBuilder = new CommentFormBuilder($comment, $user->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();
        }

        $article = $this->managers->getManagerOf('Article')->get($params['id']);
        $comments = $this->managers->getManagerOf('Comment')->getListOf($params['id']);

        return $this->render("@public/articleOne.html.twig", [
            'article'=>$article,
            "form"=> $form->createView(),
            "comments" => $comments]);
    }


    public function contactMe():Response
    {
        $request = $this->getApp()->getRequest();

        $data = $request->postData('form_contact');

        if ($data['crsf_token'] != $this->getApp()->getUser()->getCrsfToken()) {
            throw new \Exception("Crsf différent", 404);
        }

        $lastname = $data['lastname'];
        $firstname = $data['firstname'];
        $email = $data['email'];
        $message = $data['message'];

        $to = $this->getApp()->getConfig()->info_user->email['value'];
        $email_subject = "Message de $lastname  $firstname";
        $email_body = "Vous avez reçu un message provenant du formulaire de contact du site web.
        \n\n"."Voici les détails:
        \n\nNom: $lastname
        \n\nPrénom: $firstname
        \n\nEmail: $email
        \n\nMessage:\n$message";
        $headers = "From: noreply@myblog.com\n";

        mail($to, $email_subject, $email_body, $headers);

        return new HTMLResponse('ok');
    }
}

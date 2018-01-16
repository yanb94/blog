<?php

namespace Application\PublicModule\Controller;

use Framework\Controller;
use Framework\Response;
use Framework\Entity\Member;

use Framework\FormBuilder\MemberFormBuilder;
use Framework\FormBuilder\LoginMemberFormBuilder;
use Framework\FormBuilder\EditMemberFormBuilder;
use Framework\FormBuilder\ChangePasswordMemberFormBuilder;

use Framework\Exception\PageNotFoundException;

class UserController extends Controller
{
    public function login():Response
    {
        $request = $this->getApp()->getRequest();
        $user = $this->getApp()->getUser();

        if ($request->method() == 'POST'
            and $request->postExists(LoginMemberFormBuilder::NAME_FORM)
            and $request->postData(LoginMemberFormBuilder::NAME_FORM)['crsf_token'] == $user->getCrsfToken()) {
            $memberPost = new Member($request->postData(LoginMemberFormBuilder::NAME_FORM));
            $formBuilder = new LoginMemberFormBuilder($memberPost, $user->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();

            if ($form->isValid()) {
                $member = $this->managers->getManagerOf('Member')->getByLogin($memberPost->getLogin());

                if ($member != null
                    and crypt($memberPost->getPassword(), $member->getSalt()) == $member->getPassword()) {
                    $user->connect($member);

                    $url = $this->getApp()->getRouter()->generateUrl('home');

                    return $this->redirect($url);
                } else {
                    $user->setFlash('Vos identifiant sont incorrect');
                }
            }
        } else {
            $member = new Member();
            $formBuilder = new LoginMemberFormBuilder($member, $user->getCrsfToken());
            $formBuilder->build();
        }


        $form = $formBuilder->getForm();

        return $this->render('@public/login.html.twig', ["form" => $form->createView()]);
    }

    public function disconnect()
    {
        $this->app->getUser()->disconnect();

        return $this->redirect($this->app->getRouter()->generateUrl('home'));
    }

    public function register():Response
    {
        $request = $this->getApp()->getRequest();
        $user = $this->getApp()->getUser();
        $router =  $this->app->getRouter();

        if ($request->method() == 'POST'
            and $request->postExists(MemberFormBuilder::NAME_FORM)
            and $request->postData(MemberFormBuilder::NAME_FORM)['crsf_token'] == $user->getCrsfToken()) {
            $member = new Member($request->postData(MemberFormBuilder::NAME_FORM));

            $formBuilder = new MemberFormBuilder($member, $user->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();

            if ($form->isValid()) {
                try {
                    $this->managers->getManagerOf('Member')->add($member);
                    $url = $router->generateUrl('confirmRegister');

                    $urlValidation = $request->getHost().$router->generateUrl(
                        'validateRegister',
                        ["confirmToken"=> $member->getConfirmationToken()]
                    );

                    $to = $member->getEmail();
                    $email_subject = "Confirmer votre inscription";
                    $email_body = "Pour valider votre inscription 
                    veuillez valider votre inscription en cliquant sur le lien suivant
                     : <a href='$urlValidation'>$urlValidation</a>
			        \n\n";
                    $headers = "From: noreply@myblog.com\n";
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

                    mail($to, $email_subject, $email_body, $headers);

                    return $this->redirect($url);
                } catch (\PDOException $e) {
                    if ($e->errorInfo[1] == 1062) {
                        $user->setFlash(
                            'Votre pseudo et/ou votre adresse email sont déjà utilisé par un autre utilisateur'
                        );
                    } else {
                        $user->setFlash(
                            "Une erreur c'est produit lors de l'envoi du formulaire veuillez réessayer ultérieurment"
                        );
                    }
                }
            }
        } else {
            $member = new Member();

            $formBuilder = new MemberFormBuilder($member, $this->app->getUser()->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();
        }

        return $this->render('@public/register.html.twig', ["form"=> $form->createView()]);
    }

    public function confirmRegister():Response
    {
        return $this->render('@public/msgForUser.html.twig', [
            "title" => "Inscription à confirmer",
            "msg" => "Votre à inscription à bien été prise en compte.
            Vous allez recevoir un email pour confirmer votre inscription"
        ]);
    }

    public function validateRegister(array $params):Response
    {
        $confirmToken = $params['confirmToken'];

        $member = $this->managers->getManagerOf('Member')->getByConfirmToken($confirmToken, false);

        if ($member != null) {
            $member->setValid(true);
            $member->setConfirmationToken('');
            $this->managers->getManagerOf('Member')->edit($member);

            return $this->render('@public/msgForUser.html.twig', [
                "title" => "Inscription Confirmé",
                "msg" => "Votre à inscription à bien été validé. Vous pouvez vous connectez dès maintenant"
            ]);
        } else {
            throw new PageNotFoundException("Page not found", 404);
        }
    }

    public function myProfile():Response
    {
        $user = $this->app->getUser();
        $memberSession = $user->getMember();
        $request = $this->getApp()->getRequest();

        $member = $this->managers->getManagerOf('Member')->get($memberSession->getId());

        if ($member == null) {
            $user->disconnect();
            throw new PageNotFoundException("Page not found", 404);
        }

        if ($request->method() == 'POST'
            and $request->postExists(EditMemberFormBuilder::NAME_FORM)
            and $request->postData(EditMemberFormBuilder::NAME_FORM)['crsf_token'] == $user->getCrsfToken()) {
            $member->hydrate($request->postData(EditMemberFormBuilder::NAME_FORM));

            $formBuilder = new EditMemberFormBuilder($member, $user->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();

            $formBuilderPassword = new ChangePasswordMemberFormBuilder($member, $user->getCrsfToken());
            $formBuilderPassword->build();

            $formPassword = $formBuilderPassword->getForm();

            if ($form->isValid()) {
                try {
                    $this->managers->getManagerOf('Member')->edit($member);
                    $user->setMember($member);
                    $url = $this->app->getRouter()->generateUrl('myProfile');
                    $user->setFlash(["profile_success"=>'Vos informations ont été modifié avec succès']);
                    return $this->redirect($url);
                } catch (\PDOException $e) {
                    if ($e->errorInfo[1] == 1062) {
                        $user->setFlash([
                            "profile_error"=>
                            'Votre pseudo et/ou votre adresse email sont déjà utilisé par un autre utilisateur']);
                    } else {
                        $user->setFlash([
                            "profile_error"=>
                            "Une erreur c'est produit lors de l'envoi du formulaire veuillez réessayer ultérieurment"]);
                    }
                }
            }
        } elseif ($request->method() == 'POST'
            and $request->postExists(ChangePasswordMemberFormBuilder::NAME_FORM)
            and $request->postData(ChangePasswordMemberFormBuilder::NAME_FORM)['crsf_token'] == $user->getCrsfToken()
        ) {
            $formBuilder = new EditMemberFormBuilder($member, $user->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();


            $actualPassword = $member->getPassword();

            $member->hydrate($request->postData(ChangePasswordMemberFormBuilder::NAME_FORM));

            $formBuilderPassword = new ChangePasswordMemberFormBuilder($member, $user->getCrsfToken());
            $formBuilderPassword->build();

            $formPassword = $formBuilderPassword->getForm();

            if ($formPassword->isValid()) {
                $oldPasswordCrypt = crypt(
                    $request->postData(ChangePasswordMemberFormBuilder::NAME_FORM)['oldPassword'],
                    $member->getSalt()
                );

                if ($oldPasswordCrypt == $actualPassword) {
                    $this->managers->getManagerOf('Member')->editPassword($member);
                    $url = $this->app->getRouter()->generateUrl('myProfile');
                    $user->setFlash(["password_success"=>'Mot de passe modifié avec succès']);
                    return $this->redirect($url);
                } else {
                    $user->setFlash(["password_error"=>'Mot de passe incorrect']);
                }
            }
        } else {
            $formBuilder = new EditMemberFormBuilder($member, $user->getCrsfToken());
            $formBuilder->build();

            $form = $formBuilder->getForm();

            $formBuilderPassword = new ChangePasswordMemberFormBuilder($member, $user->getCrsfToken());
            $formBuilderPassword->build();

            $formPassword = $formBuilderPassword->getForm();
        }

        return $this->render("@public/myProfile.html.twig", [
            "form"=> $form->createView(),
            "formPassword"=> $formPassword->createView()]);
    }
}

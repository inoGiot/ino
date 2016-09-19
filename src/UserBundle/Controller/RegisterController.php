<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Entity\User;
use UserBundle\Forms\RegisterFormType;


class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm('UserBundle\Forms\RegisterFormType', $user);
        $form->handleRequest($request);
        if($form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();

            $url = $this->generateUrl('articles');
            return $this->redirect($url);
        }

        return array('form' => $form->createView());
    }
}
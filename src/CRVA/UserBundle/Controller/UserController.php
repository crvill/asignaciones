<?php

namespace CRVA\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CRVA\UserBundle\Entity\User;
use CRVA\UserBundle\Form\UserType;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$users = $em->getRepository('CRVAUserBundle:User')->findAll();
        

        /**$res = 'Lista de usuarios: <br/>';

        foreach ($users as $user) {
            $res .= 'Usuario: ' . $user->getUsername() . ' - Email: '. $user->getEmail(). '<br/>';
        }

        return new Response($res);**/

        $dql = "SELECT u FROM CRVAUserBundle:User u";
        $users = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,$request->query->getInt('page',1),
            6
        );

        return $this->render('CRVAUserBundle:User:index.html.twig', array('pagination' => $pagination));
    }

    public function addAction()
    {
        $user = new User();
        $form = $this->createCreateForm($user);

        return $this->render('CRVAUserBundle:User:add.html.twig', array('form' => $form->createView()));
    }

    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('crva_user_create'),
            'method' => 'POST'
            ));
        return $form;
    }

    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);

        if($form->isValid()){

            $password = $form->get('password')->getData();

            $encoder = $this->container->get('security.password_encoder');
            $encoder = $encoder->encodePassword($user,$password);
            
            $user->setPassword($encoder);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $successMessage = $this->get('translator')->trans('The user has been created.');
            $this->addFlash('mensaje', $successMessage);

            return $this->redirectToRoute("crva_user_index"); 
        }

        return $this->render('CRVAUserBundle:User:add.html.twig', array('form' => $form->createView()));
    }

    public function editAction()
    {
        
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getRepository('CRVAUserBundle:User');

        $user = $em->find($id);

        return new Response('Usuario: ' . $user->getUsername() . ' con Email: '. $user->getEmail(). '<br/>');    
    }

    public function deleteAction()
    {
        
    }
}

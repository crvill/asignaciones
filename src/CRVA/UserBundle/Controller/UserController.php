<?php

namespace CRVA\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CRVA\UserBundle\Entity\User;
use CRVA\UserBundle\Form\UserType;

class UserController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('CRVAUserBundle:User')->findAll();

        /**$res = 'Lista de usuarios: <br/>';

        foreach ($users as $user) {
            $res .= 'Usuario: ' . $user->getUsername() . ' - Email: '. $user->getEmail(). '<br/>';
        }

        return new Response($res);**/

        return $this->render('CRVAUserBundle:User:index.html.twig', array('users' => $users));
    }

    public function addAction()
    {
        $user = new User();
        $form = $this->createCreateForm($user);

        return $this->render('CRVAUserBundle:User:add.html.twig', array('form' => $form->createView()));
    }

    private createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('crva_user_create'),
            'method' => 'POST'
            ));
        return $form;
    }

    public function createAction(Request $request)
    {
        # code...
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

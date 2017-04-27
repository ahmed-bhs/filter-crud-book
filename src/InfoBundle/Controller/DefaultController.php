<?php

namespace InfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {$titre=$request->query->get('titre');
  //  var_dump($titre);
if (isset($titre) && !empty($titre))

{ $info=   $this->getDoctrine()->getRepository('InfoBundle:Info1')->findAll();//->recherche($titre);
dump( $info);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate( $info, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
           10/*limit per page*/
        );



        return $this->render('InfoBundle:Default:index.html.twig',array('pagination' => $pagination,'rech'=>$titre));
         }
else {
     $info=   $this->getDoctrine()->getRepository('InfoBundle:Info1')->findAll();dump( $info);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate( $info, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('InfoBundle:Default:index.html.twig',array('pagination' => $pagination));}
    }

}
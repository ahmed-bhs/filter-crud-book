<?php

namespace InfoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use InfoBundle\Entity\Info;

/**
 * Info controller.
 *
 */
class InfoController extends Controller
{
    /**
     * Lists all Info entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('InfoBundle:Info')->createQueryBuilder('e');
        
        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($infos, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        return $this->render('info/index.html.twig', array(
            'infos' => $infos,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),

        ));
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter($queryBuilder, Request $request)
    {
        $session = $request->getSession();
        $filterForm = $this->createForm('InfoBundle\Form\InfoFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('InfoControllerFilter');
        }

        // Filter action
        if ($request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->handleRequest($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('InfoControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('InfoControllerFilter')) {
                $filterData = $session->get('InfoControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('InfoBundle\Form\InfoFilterType', $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }


    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder, Request $request)
    {
        //sorting
        $sortCol = $queryBuilder->getRootAlias().'.'.$request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show' , 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }
        
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me, $request)
        {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl('admin_info', $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap3View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => 'previous',
            'next_message' => 'next',
        ));

        return array($entities, $pagerHtml);
    }
    
    

    /**
     * Displays a form to create a new Info entity.
     *
     */
    public function newAction(Request $request)
    {
    
        $info = new Info();
        $form   = $this->createForm('InfoBundle\Form\InfoType', $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($info);
            $em->flush();
            
            $editLink = $this->generateUrl('admin_info_edit', array('id' => $info->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New info was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'admin_info' : 'admin_info_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('info/new.html.twig', array(
            'info' => $info,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Info entity.
     *
     */
    public function showAction(Info $info)
    {
        $deleteForm = $this->createDeleteForm($info);
        return $this->render('info/show.html.twig', array(
            'info' => $info,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Info entity.
     *
     */
    public function editAction(Request $request, Info $info)
    {
        $deleteForm = $this->createDeleteForm($info);
        $editForm = $this->createForm('InfoBundle\Form\InfoType', $info);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($info);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('admin_info_edit', array('id' => $info->getId()));
        }
        return $this->render('info/edit.html.twig', array(
            'info' => $info,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Info entity.
     *
     */
    public function deleteAction(Request $request, Info $info)
    {
    
        $form = $this->createDeleteForm($info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($info);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Info was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Info');
        }
        
        return $this->redirectToRoute('admin_info');
    }
    
    /**
     * Creates a form to delete a Info entity.
     *
     * @param Info $info The Info entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Info $info)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_info_delete', array('id' => $info->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Info by id
     *
     */
    public function deleteByIdAction(Info $info){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($info);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Info was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Info');
        }

        return $this->redirect($this->generateUrl('admin_info'));

    }
    

    /**
    * Bulk Action
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('InfoBundle:Info');

                foreach ($ids as $id) {
                    $info = $repository->find($id);
                    $em->remove($info);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'infos was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the infos ');
            }
        }

        return $this->redirect($this->generateUrl('admin_info'));
    }
    

}

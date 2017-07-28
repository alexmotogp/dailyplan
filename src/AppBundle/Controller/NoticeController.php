<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Notice;
use AppBundle\Form\NoticeForm;

class NoticeController extends Controller {
        
    public function showNoticesAction() {
        ;
    }
    
    /**
     * @Route("/add-notice", name="add-notice")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addNoticeAction(Request $request) {
        $notice = new Notice();
        $form = $this->createForm(NoticeForm::class, $notice);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notice);
            $em->flush();
            
            $this->redirectToRoute('homepage');
        }
        
        return $this->render('notice/addnotice.html.twig', array('form' => $form->createView()));
    }
    
    public function delNoticeAction($id) {
        ;
    }
    
}
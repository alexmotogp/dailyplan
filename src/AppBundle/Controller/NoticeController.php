<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Notice;
use AppBundle\Form\NoticeForm;

class NoticeController extends Controller
{

    public function showNoticesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $qSQL = 'SELECT n FROM AppBundle:Notice n'; // Here will added condition to select by user id
        $query = $em->createQuery($qSQL);
        $notices = $query->getResult();
        return $this->render('notice/shownotice.html.twig', array(
            'notices' => $notices
        ));
    }

    /**
     * @Route("/add-notice", name="add-notice")
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addNoticeAction(Request $request)
    {
        $notice = new Notice();
        $form = $this->createForm(NoticeForm::class, $notice, array(
            'action' => $this->generateUrl('add-notice')
        ));
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notice);
            $em->flush();
            
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('notice/addnotice.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/del-notice/{id}", name="del-notice")
     * 
     * @param unknown $id
     */
    public function delNoticeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $notice = $em->getRepository(Notice::class)->find($id);
        
        if (! $notice) {
            throw $this->createNotFoundException('No task with id:' . $id);
        }
        
        $em->remove($notice);
        $em->flush();
        
        return $this->redirectToRoute('homepage');
    }

    public function editNoticeAction($id)
    {}
}
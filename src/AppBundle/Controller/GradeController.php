<?php // src/AppBundle/GradeController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Grade;
use AppBundle\Form\GradeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GradeController
 */
class GradeController extends Controller
{
    /**
     * @Route("/grade", name="grade_list")
     */
    public function indexAction()
    {
        $grades = $this->getDoctrine()->getManager()->getRepository('AppBundle:grade')->findAll();

        return $this->render('AppBundle:grade:index.html.twig', [
            'grades' => $grades
        ]);
    }
    /**
     * @Route("/admin/grade/add", name="grade_add")
     */
    public function addAction(Request $request)
    {
        $grade = new Grade();
        $form = $this->createForm(new GradeType(),$grade);

        if($request->isMethod('POST') && $form->handleRequest($request) && $form->isValid()){
            $db = $this->getDoctrine()->getManager();
            $db->persist($grade);
            $db->flush();

            return $this->redirectToRoute('grade_list');
        }

        return $this->render('AppBundle:Grade:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @route("/admin/grade/delete/{id}", name="grade_delete")
     */
    public function deleteAction($id)
    {
        $db = $this->getDoctrine()->getManager();

        $grade = $db
            ->getRepository('AppBundle:Grade')
            ->find($id);

        $db->remove($grade);
        $db->flush();

        return $this->redirectToRoute('grade_list');
    }
}
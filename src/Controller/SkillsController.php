<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Form\SkillsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SkillsController extends AbstractController
{
    /**
     * @Route("/admin/skills", name="admin_skills")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();
        $skillsData = $em->getRepository(Skills::class)->findAll();

        return $this->render('skills/index.html.twig', [
            'skillsData' => $skillsData,
        ]);
    }

    /**
     * @Route("/admin/skills/new", name="admin_skills_new")
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $newSkill = new Skills();
        $form = $this->createForm(SkillsType::class, $newSkill);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $newSkill->setIsPublic(0);
            $newSkill->setUploadedAt(new \DateTime());
            $newSkill->setModificatedAt(new \DateTime());
            $em->persist($newSkill);
            $em->flush();
            return $this->redirectToRoute('admin_skills');
        }

        return $this->render('skills/new.html.twig', [
            'skillsForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/skills/edit/{id}", name="admin_skills_edit")
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository(Skills::class)->find($id);
        $form = $this->createForm(SkillsType::class, $skill);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $skill->setModificatedAt(new \DateTime());
            $em->persist($skill);
            $em->flush();
            return $this->redirectToRoute('admin_skills');
        }


        return $this->render('skills/new.html.twig', [
            'skillsForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/skills/delete/{id}", name="admin_skills_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository(Skills::class)->find($id);
        $em->remove($skill);
        $em->flush();
        return $this->redirectToRoute('admin_skills');
    }

    /**
     * @Route("/admin/skills/set_visibility/{id}{visibility}", name="admin_skills_set_visibility")
     */
    public function makeVisible($id, $visibility)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository(Skills::class)->find($id);
        $skill->setModificatedAt(new \DateTime());
        $skill->setIsPublic($visibility);
        $em->persist($skill);
        $em->flush();
        return $this->redirectToRoute('admin_skills');
    }
}

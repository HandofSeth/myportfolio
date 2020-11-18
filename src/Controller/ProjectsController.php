<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Form\ProjectsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProjectsController extends AbstractController
{
    /**
     * @Route("/admin/projects", name="admin_projects")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();
        $projectsData = $em->getRepository(Projects::class)->findAll();

        return $this->render('projects/index.html.twig', [
            'projectsData' => $projectsData,
        ]);
    }

    /**
     * @Route("/admin/projects/new", name="admin_projects_new")
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $newProjects = new Projects();
        $form = $this->createForm(ProjectsType::class, $newProjects);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $pictureFileName = $form->get('photo_path')->getData();
            if ($pictureFileName) {
                try {
                    $oryginalFileName = pathinfo($pictureFileName->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $oryginalFileName);
                    $newFileNamePhoto = $safeFileName . '-' . uniqid() . '.' . $pictureFileName->guessExtension();
                    $pictureFileName->move('download/', $newFileNamePhoto);

                    $newProjects->setPhotoPath($newFileNamePhoto);
                    $em->persist($newProjects);
                    $em->flush();
                    $this->addFlash('success', 'Dodano zdjęcie');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
                }
            }
            return $this->redirectToRoute('admin_projects');
        }


        return $this->render('projects/new.html.twig', [
            'projectsForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/projects/edit/{id}", name="admin_projects_edit")
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Projects::class)->find($id);
        $form = $this->createForm(ProjectsType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute('admin_projects');
        }


        return $this->render('projects/new.html.twig', [
            'projectsForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/projects/delete/{id}", name="admin_projects_delete")
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $skill = $em->getRepository(Skills::class)->find($id);
        $em->remove($skill);
        $em->flush();
        return $this->redirectToRoute('admin_skills');
    }
}

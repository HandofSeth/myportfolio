<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Form\ProjectsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
                    $newProjects->setIsPublic(0);
                    $newProjects->setUploadedAt(new \DateTime());
                    $newProjects->setModificatedAt(new \DateTime());
                    $em->persist($newProjects);
                    $em->flush();
                    $this->addFlash('success', 'Dodano Projekt');
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
            $pictureFileName = $form->get('photo_path')->getData();
            if ($pictureFileName) {
                try {
                    $oryginalFileName = pathinfo($pictureFileName->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9] remove; Lower()', $oryginalFileName);
                    $newFileNamePhoto = $safeFileName . '-' . uniqid() . '.' . $pictureFileName->guessExtension();
                    $pictureFileName->move('download/', $newFileNamePhoto);

                    $project->setPhotoPath($newFileNamePhoto);
                    $project->setIsPublic(0);
                    $project->setModificatedAt(new \DateTime());
                    $em->persist($project);
                    $em->flush();
                    $this->addFlash('success', 'Zedytowano projekt');
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
     * @Route("/admin/projects/delete/{id}", name="admin_projects_delete")
     * @param Request $request
     * $return \Symfony\Component\HttpFoundation\Response
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Projects::class)->find($id);
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('admin_projects');
    }

    /**
     * @Route("/admin/projects/set_visibility/{id}{visibility}", name="admin_projects_set_visibility")
     */
    public function makeVisible($id, $visibility)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Projects::class)->find($id);
        $project->setModificatedAt(new \DateTime());
        $project->setIsPublic($visibility);
        $em->persist($project);
        $em->flush();
        return $this->redirectToRoute('admin_projects');
    }
}

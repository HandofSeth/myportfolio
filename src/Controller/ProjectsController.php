<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Form\ProjectsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use App\Service\ImagesUploadService;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function new(Request $request,  ImagesUploadService $imageUploadService, SluggerInterface $slugger)
    {
        $newProjects = new Projects();
        $form = $this->createForm(ProjectsType::class, $newProjects);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pictureFileName = $form->get('photo_path')->getData();
            try {
                if ($pictureFileName != null) {
                    $newFileNamePhoto = $imageUploadService->uploadNewImage($pictureFileName,$slugger);
                    $newProjects->setPhotoPath($newFileNamePhoto);
                }

                $newProjects->setIsPublic(0);
                $newProjects->setUploadedAt(new \DateTime());
                $newProjects->setModificatedAt(new \DateTime());
                $em->persist($newProjects);
                $em->flush();
                $this->addFlash('success', 'Dodano Projekt');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
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
    public function edit(Request $request, $id, ImagesUploadService $imageUploadService, SluggerInterface $slugger)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Projects::class)->find($id);
        $form = $this->createForm(ProjectsType::class, $project);
        $oldFilePath = $project->getPhotoPath();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFileName = $form->get('photo_path')->getData();

            try {
                if ($pictureFileName != null) {
                    $newFileNamePhoto = $imageUploadService->uploadEditImage($pictureFileName, $oldFilePath,$slugger);
                    $project->setPhotoPath($newFileNamePhoto);
                } else {
                    $project->setPhotoPath($oldFilePath);
                }
                $project->setModificatedAt(new \DateTime());
                $em->persist($project);
                $em->flush();
                $this->addFlash('success', 'Zedytowano projekt');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
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
        $filesystem = new Filesystem();
        try {
            $em = $this->getDoctrine()->getManager();
            $project = $em->getRepository(Projects::class)->find($id);
            $filesystem->remove(['download/' . $project->getPhotoPath()]);
            $em->remove($project);
            $em->flush();
            $this->addFlash('success', 'Usunięto projekt');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Wystąpił nieoczekiwany błąd podczas usuwania');
        }
        return $this->redirectToRoute('admin_projects');
    }

    /**
     * @Route("/admin/projects/set_visibility/{id}{visibility}", name="admin_projects_set_visibility")
     */
    public function makeVisible($id, $visibility)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $project = $em->getRepository(Projects::class)->find($id);
            $project->setModificatedAt(new \DateTime());
            $project->setIsPublic($visibility);
            $em->persist($project);
            $em->flush();
            $this->addFlash('success', 'Zaktulizowano widoczność');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Wystąpił nieoczekiwany błąd');
        }
        return $this->redirectToRoute('admin_projects');
    }
}

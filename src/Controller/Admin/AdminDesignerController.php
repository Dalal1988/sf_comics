<?php

namespace App\Controller\Admin;

use App\Entity\Designer;
use App\Form\DesignerType;
use App\Repository\DesignerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDesignerController extends AbstractController
{

    /**
     * @Route("admin/designers", name="admin_designers_list")
     */
    public function adminListDesigners(DesignerRepository $designerRepository)
    {
        $designers = $designerRepository->findAll();

        return $this->render("admin/designers.html.twig", ['designers' => $designers]);
    }

    /**
     * @Route("admin/designer/{id}", name="admin_designer_show")
     */
    public function adminShowDesigner($id, DesignerRepository $designerRepository)
    {
        $designer = $designerRepository->find($id);

        return $this->render("admin/designer.html.twig", ['designer' => $designer]);
    }

    /**
     * @Route("admin/update/designer/{id}", name="admin_update_designer")
     */
    public function adminUpdateDesigner(
        $id,
        DesignerRepository $designerRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $designer = $designerRepository->find($id);

        $designerForm = $this->createForm(DesignerType::class, $designer);

        $designerForm->handleRequest($request);

        if ($designerForm->isSubmitted() && $designerForm->isValid()) {
            $entityManagerInterface->persist($designer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_designers_list");
        }


        return $this->render("admin/designerForm.html.twig", ['designerForm' => $designerForm->createView()]);
    }

    /**
     * @Route("admin/create/designer/", name="admin_designer_create")
     */
    public function adminDesignerCreate(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $designer = new Designer();

        $designerForm = $this->createForm(DesignerType::class, $designer);

        $designerForm->handleRequest($request);

        if ($designerForm->isSubmitted() && $designerForm->isValid()) {
            $entityManagerInterface->persist($designer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_designers_list");
        }


        return $this->render("admin/designerForm.html.twig", ['designerForm' => $designerForm->createView()]);
    }

    /**
     * @Route("admin/delete/designer/{id}", name="admin_delete_designer")
     */
    public function adminDeleteDesigner(
        $id,
        DesignerRepository $designerRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $designer = $designerRepository->find($id);

        $entityManagerInterface->remove($designer);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_designers_list");
    }
}
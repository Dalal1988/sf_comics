<?php

namespace App\Controller\Front;

use App\Repository\DesignerRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DesignerController extends AbstractController
{

    /**
     * @Route("designers", name="designer_list")
     */
    public function designerList(DesignerRepository $designerRepository)
    {
        $designers = $designerRepository->findAll();

        return $this->render("front/designers.html.twig", ['designers' => $designers]);
    }

    /**
     * @Route("designer/{id}", name="designer_show")
     */
    public function designerShow($id, DesignerRepository $designerRepository)
    {
        $designer = $designerRepository->find($id);

        return $this->render("front/designer.html.twig", ['designer' => $designer]);
    }
}
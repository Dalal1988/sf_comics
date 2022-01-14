<?php

namespace App\Controller\Front;

use App\Repository\ComicsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComicsController extends AbstractController
{

    /**
     * @Route("comics", name="comics_list")
     */
    public function comicsList(ComicsRepository $comicsRepository)
    {
        $comics = $comicsRepository->findAll();

        return $this->render("front/comics.html.twig", ['comics' => $comics]);
    }

    /**
     * @Route("comic/{id}", name="comics_show")
     */
    public function comicsShow($id, ComicsRepository $comicsRepository)
    {
        $comics = $comicsRepository->find($id);

        return $this->render("front/comic.html.twig", ['comics' => $comics]);
    }
}
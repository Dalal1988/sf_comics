<?php

namespace App\Controller\Admin;

use App\Entity\Comics;
use App\Form\ComicType;
use App\Repository\ComicsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminComicsController extends AbstractController
{

    /**
     * @Route("admin/comics", name="admin_comics_list")
     */
    public function adminListComics(ComicsRepository $comicsRepository)
    {
        $comics = $comicsRepository->findAll();

        return $this->render("admin/comics.html.twig", ['comics' => $comics]);
    }

    /**
     * @Route("admin/comic/{id}", name="admin_comics_show")
     */
    public function adminShowComics($id, ComicsRepository $comicsRepository)
    {
        $comic = $comicsRepository->find($id);

        return $this->render("admin/comic.html.twig", ['comic' => $comic]);
    }

    /**
     * @Route("admin/update/comic/{id}", name="admin_update_comic")
     */
    public function adminUpdatecomics(
        $id,
        ComicsRepository $comicsRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $comic = $comicsRepository->find($id);

        $comicForm = $this->createForm(ComicType::class, $comic);

        $comicForm->handleRequest($request);

        if ($comicForm->isSubmitted() && $comicForm->isValid()) {
            $entityManagerInterface->persist($comic);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_comics_list");
        }


        return $this->render("admin/comicsForm.html.twig", ['comicForm' => $comicForm->createView()]);
    }

    /**
     * @Route("admin/create/comic/", name="admin_comic_create")
     */
    public function adminComicCreate(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $comic = new Comics();

        $comicForm = $this->createForm(ComicType::class, $comic);

        $comicForm->handleRequest($request);

        if ($comicForm->isSubmitted() && $comicForm->isValid()) {
            $entityManagerInterface->persist($comic);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_comics_list");
        }


        return $this->render("admin/comicsForm.html.twig", ['comicForm' => $comicForm->createView()]);
    }

    /**
     * @Route("admin/delete/comic/{id}", name="admin_delete_comic")
     */
    public function adminDeleteComic(
        $id,
        ComicsRepository $comicsRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $comic = $comicsRepository->find($id);

        $entityManagerInterface->remove($comic);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_comics_list");
    }
}
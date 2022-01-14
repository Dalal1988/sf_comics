<?php

namespace App\Controller\Admin;

use App\Entity\Writer;
use App\Form\WriterType;
use App\Repository\WriterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminWriterController extends AbstractController
{

    /**
     * @Route("admin/writers", name="admin_writers_list")
     */
    public function adminListWriters(WriterRepository $writerRepository)
    {
        $writers = $writerRepository->findAll();

        return $this->render("admin/writers.html.twig", ['writers' => $writers]);
    }

    /**
     * @Route("admin/writer/{id}", name="admin_writer_show")
     */
    public function adminShowWriter($id, WriterRepository $writerRepository)
    {
        $writer = $writerRepository->find($id);

        return $this->render("admin/writer.html.twig", ['writer' => $writer]);
    }

    /**
     * @Route("admin/update/writer/{id}", name="admin_update_writer")
     */
    public function adminUpdateWriter(
        $id,
        WriterRepository $writerRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $writer = $writerRepository->find($id);

        $writerForm = $this->createForm(WriterType::class, $writer);

        $writerForm->handleRequest($request);

        if ($writerForm->isSubmitted() && $writerForm->isValid()) {
            $entityManagerInterface->persist($writer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_writers_list");
        }


        return $this->render("admin/writerForm.html.twig", ['writerForm' => $writerForm->createView()]);
    }

    /**
     * @Route("admin/create/writer/", name="admin_writer_create")
     */
    public function adminWriterCreate(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $writer = new Writer();

        $writerForm = $this->createForm(WriterType::class, $writer);

        $writerForm->handleRequest($request);

        if ($writerForm->isSubmitted() && $writerForm->isValid()) {
            $entityManagerInterface->persist($writer);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_writers_list");
        }


        return $this->render("admin/writerForm.html.twig", ['writerForm' => $writerForm->createView()]);
    }

    /**
     * @Route("admin/delete/writer/{id}", name="admin_delete_writer")
     */
    public function adminDeleteWriter(
        $id,
        WriterRepository $writerRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $writer = $writerRepository->find($id);

        $entityManagerInterface->remove($writer);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_writers_list");
    }
}
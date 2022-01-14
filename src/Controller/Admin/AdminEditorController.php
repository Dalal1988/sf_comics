<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminEditorController extends AbstractController
{

    /**
     * @Route("admin/editors", name="admin_editors_list")
     */
    public function adminListEditors(EditorRepository $editorRepository)
    {
        $editors = $editorRepository->findAll();

        return $this->render("admin/editors.html.twig", ['editors' => $editors]);
    }

    /**
     * @Route("admin/editor/{id}", name="admin_editor_show")
     */
    public function adminShowEditor($id, EditorRepository $editorRepository)
    {
        $editor = $editorRepository->find($id);

        return $this->render("admin/editor.html.twig", ['editor' => $editor]);
    }

    /**
     * @Route("admin/update/editor/{id}", name="admin_update_editor")
     */
    public function adminUpdateEditor(
        $id,
        EditorRepository $editorRepository,
        Request $request,
        EntityManagerInterface $entityManagerInterface
    ) {

        $editor = $editorRepository->find($id);

        $editorForm = $this->createForm(EditorType::class, $editor);

        $editorForm->handleRequest($request);

        if ($editorForm->isSubmitted() && $editorForm->isValid()) {
            $entityManagerInterface->persist($editor);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_editor_list");
        }


        return $this->render("admin/editorForm.html.twig", ['editorForm' => $editorForm->createView()]);
    }

    /**
     * @Route("admin/create/editor/", name="admin_editor_create")
     */
    public function adminEditorCreate(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $editor = new Editor();

        $editorForm = $this->createForm(DesignerType::class, $editor);

        $editorForm->handleRequest($request);

        if ($editorForm->isSubmitted() && $editorForm->isValid()) {
            $entityManagerInterface->persist($editor);
            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_editor_list");
        }


        return $this->render("admin/editorForm.html.twig", ['editorForm' => $editorForm->createView()]);
    }

    /**
     * @Route("admin/delete/editor/{id}", name="admin_delete_editor")
     */
    public function adminDeleteEditor(
        $id,
        EditorRepository $editorRepository,
        EntityManagerInterface $entityManagerInterface
    ) {

        $editor = $editorRepository->find($id);

        $entityManagerInterface->remove($editor);

        $entityManagerInterface->flush();

        return $this->redirectToRoute("admin_editor_list");
    }
}
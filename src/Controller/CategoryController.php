<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\EntryTag;
use App\Form\CategoryType;
use App\Form\EntryType;
use App\Repository\CategoryRepository;
use App\Repository\EntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/list", name="category_index")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findBy([],[
            'account' => 'asc',
            'label' => 'asc'
        ]);

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/add", name="category_add")
     * @Route("/{id}/edit", name="category_edit")
     */
    public function edit(Request $request, Category $category = null, EntryRepository $entryRepository)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_index');
        }

        $entryTags = $entryRepository->getEntryDistinctLabels();

        return $this->render('category/edit.html.twig', [
            'tags' => $entryTags,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add_entry_tag/", name="category_add_entry_tag", options={"expose" = true})
     */
    public function addEntryTag(Request $request, CategoryRepository $categoryRepository)
    {
//        if (!$request->isXmlHttpRequest()) {
//            throw new \BadMethodCallException("Only AJAX request supported!");
//        }

        $id = $request->get('id');

        $category = $categoryRepository->find($id);
        if ($category != null) {
            $entryTag = new EntryTag();
            $entryTag->setTagLabel($request->get('tagLabel'));

            $category->addTag($entryTag);
            $this->getDoctrine()->getManager()->flush();
        }
        return new JsonResponse();
    }
}

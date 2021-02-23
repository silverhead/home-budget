<?php

namespace App\Controller;

use App\Entity\Entry;
use App\Form\EntryListSearchType;
use App\Form\EntryType;
use App\Form\ImportEntryType;
use App\Form\Model\EntryListSearch;
use App\Form\Model\ImportEntry;
use App\Repository\AccountRepository;
use App\Repository\CategoryRepository;
use App\Repository\EntryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\ImportEntryService;

/**
 * @Route("/entry")
 */
class EntryController extends AbstractController
{
    /**
     * @Route("/list/{accountId}", name="entry_index", methods={"GET", "POST"})
     */
    public function index(Request $request, EntryRepository $entryRepository, AccountRepository $accountRepository, CategoryRepository $categoryRepository, SessionInterface $session, $accountId): Response
    {
        $dateNow = new \DateTime();
        $entrySearch = new EntryListSearch();
        $entrySearch->setDateStart(\DateTime::createFromFormat("Y-m-d", $dateNow->format("Y-m-01")));
        $entrySearch->setDateEnd(\DateTime::createFromFormat("Y-m-d", $dateNow->format("Y-m-t")));

        if($session->get('entrySearch') != null){
            $entrySearch->setDateStart($session->get('entrySearch')['dateStart']);
            $entrySearch->setDateEnd($session->get('entrySearch')['dateEnd']);
        }

        $formSearch = $this->createForm(EntryListSearchType::class, $entrySearch);
        $formSearch->handleRequest($request);

        if ($formSearch->isSubmitted() && $formSearch->isValid()){
            $entrySearch = $formSearch->getData();
            $session->set('entrySearch', array(
                'dateStart' => $entrySearch->getDateStart(),
                'dateEnd' => $entrySearch->getDateEnd()
            ));
        }

        $account = $accountRepository->find($accountId);

        $categories = $categoryRepository->findBy(['account' => $account], ['label' => 'ASC']);

        $entries = $entryRepository->getByPeriodAndAccount(
            $accountId,
            $entrySearch->getDateStart(),
            $entrySearch->getDateEnd(),
            ['e.date' => 'desc']
        );

        foreach ($entries as $entry) {
            foreach ($categories as $category) {
                $category->addAmountByTag($entry);
            }
        }

        $totalPeriod = $entryRepository->getSoldTotalEndPeriod($accountId, $entrySearch->getDateEnd());

        return $this->render('entry/index.html.twig', [
            'entries' => $entries,
            'debitSum' => array_sum(array_map(function($entry){ return $entry->getDebit(); }, $entries)),
            'creditSum' => array_sum(array_map(function($entry){ return $entry->getCredit(); }, $entries)),
            'dateStartOfPeriod' => $entrySearch->getDateStart(),
            'dateEndOfPeriod' => $entrySearch->getDateEnd(),
            'account' => $account,
            'categories' => $categories,
            'soldTotalPeriod' => $account->getSoldeInit()+$totalPeriod,
            'form' => $formSearch->createView()
        ]);
    }

    /**
     * @Route("/new", name="entry_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $entry = new Entry();
        $form = $this->createForm(EntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entry);
            $entityManager->flush();

            return $this->redirectToRoute('entry_index');
        }

        return $this->render('entry/new.html.twig', [
            'entry' => $entry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entry_show", methods={"GET"})
     */
    public function show(Entry $entry): Response
    {
        return $this->render('entry/show.html.twig', [
            'entry' => $entry,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entry_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entry $entry): Response
    {
        $form = $this->createForm(EntryType::class, $entry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entry_index');
        }

        return $this->render('entry/edit.html.twig', [
            'entry' => $entry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entry_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entry $entry): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entry->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entry_index');
    }

    /**
     * @Route("/import/download/{accountId}", name="entry_import_download", methods={"GET", "POST"})
     */
    public function import(Request $request, int $accountId, AccountRepository $accountRepository, ImportEntryService $importEntryService)
    {
        $form = $this->createForm(ImportEntryType::class, new ImportEntry());
        $form->handleRequest($request);

        $account = $accountRepository->find($accountId);

        if ($form->isSubmitted() && $form->isValid()) {
            $root = $this->getParameter('kernel.project_dir');
            $pathImport = $root.DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."import";

            $model = $form->getData();
            $model->getFile()->move($pathImport, $model->getFile()->getFilename());
            $pathFile = $pathImport.DIRECTORY_SEPARATOR.$model->getFile()->getFilename();

            $importEntryService->setStartLineToRead(6);
            $importEntryService->setNbEndLinesToIgnore(1);
            $importEntryService->setAccount($account);
            $importEntryService->import($pathFile);

            if (count($importEntryService->getErrors()) == 0){
                $this->addFlash('success', "Import réussi!");
            }
            else{
                $messageError = "";
                foreach($importEntryService->getErrors() as $error){
                    // todo use translator
                    if ($error[0] == 'import.error.min_nb_column_require'){
                        $messageError.=$messageError!=""?"<br>":"";
                        $messageError.= "Nombre de colonne requit insuffisant à la ligne ".$error[1];
                    }
                }

                $this->addFlash('error', "Erreur lors de l'import : <br>" .$messageError);
            }
        }

        return $this->render('entry/import_download.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

<?php

/**
 * TaskList controller.
 */

namespace App\Controller;

use App\Entity\TaskList;
use App\Form\Type\TaskListType;
use App\Service\TaskListServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class TaskListController.
 */
#[Route('/tasklist')]
class TaskListController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param TaskListServiceInterface $taskListService TaskList service
     * @param TranslatorInterface      $translator      Translator
     */
    public function __construct(private readonly TaskListServiceInterface $taskListService, private readonly TranslatorInterface $translator)
    {
    }

    /**
     * Index action.
     *
     * @param int $page Page number
     *
     * @return Response HTTP response
     */
    #[Route(name: 'tasklist_index', methods: 'GET')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->taskListService->getPaginatedList($page);

        return $this->render('tasklist/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * View action.
     *
     * @param TaskList $taskList TaskList entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'tasklist_view',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function view(TaskList $taskList): Response
    {
        return $this->render(
            'tasklist/view.html.twig',
            ['taskList' => $taskList]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'tasklist_create',
        methods: 'GET|POST'
    )]
    public function create(Request $request): Response
    {
        $taskList = new TaskList();
        $form = $this->createForm(TaskListType::class, $taskList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskListService->save($taskList);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('tasklist_index');
        }

        return $this->render(
            'tasklist/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param TaskList $taskList TaskList entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/edit',
        name: 'tasklist_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Request $request, TaskList $taskList): Response
    {
        $form = $this->createForm(
            TaskListType::class,
            $taskList,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('tasklist_edit', ['id' => $taskList->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskListService->save($taskList);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('tasklist_index');
        }

        return $this->render(
            'tasklist/edit.html.twig',
            [
                'form' => $form->createView(),
                'taskList' => $taskList,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param TaskList $taskList TaskList entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/delete',
        name: 'tasklist_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Request $request, TaskList $taskList): Response
    {
        if (!$this->taskListService->canBeDeleted($taskList)) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.lista_contains_tasks')
            );

            return $this->redirectToRoute('tasklist_index');
        }

        $form = $this->createForm(FormType::class, $taskList, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('tasklist_delete', ['id' => $taskList->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->taskListService->delete($taskList);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('tasklist_index');
        }

        return $this->render(
            'tasklist/delete.html.twig',
            [
                'form' => $form->createView(),
                'taskList' => $taskList,
            ]
        );
    }
}

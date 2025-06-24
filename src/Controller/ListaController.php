<?php

/**
 * Lista controller.
 */

namespace App\Controller;

use App\Entity\Lista;
use App\Form\Type\ListaType;
use App\Service\ListaServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ListaController.
 */
#[Route('/lista')]
class ListaController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param ListaServiceInterface $listaService Lista service
     * @param TranslatorInterface   $translator   Translator
     */
    public function __construct(private readonly ListaServiceInterface $listaService, private readonly TranslatorInterface $translator)
    {
    }

    /**
     * Index action.
     *
     * @param int $page Page number
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'lista_index',
        methods: 'GET'
    )]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->listaService->getPaginatedList($page);

        return $this->render('lista/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * View action.
     *
     * @param Lista $lista Lista entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'lista_view',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function view(Lista $lista): Response
    {
        return $this->render(
            'lista/view.html.twig',
            ['lista' => $lista]
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
        name: 'lista_create',
        methods: 'GET|POST'
    )]
    public function create(Request $request): Response
    {
        $lista = new Lista();
        $form = $this->createForm(ListaType::class, $lista);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->listaService->save($lista);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('lista_index');
        }

        return $this->render(
            'lista/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Lista   $lista   Lista entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}/edit",
     *     name="lista_edit",
     *     requirements={"id"="[1-9]\d*"},
     *     methods="GET|PUT"
     * )
     */
    #[Route(
        '/{id}/edit',
        name: 'lista_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Request $request, Lista $lista): Response
    {
        $form = $this->createForm(
            ListaType::class,
            $lista,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('lista_edit', ['id' => $lista->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->listaService->save($lista);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('lista_index');
        }

        return $this->render(
            'lista/edit.html.twig',
            [
                'form' => $form->createView(),
                'lista' => $lista,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Lista   $lista   Lista entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/delete',
        name: 'lista_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Lista $lista): Response
    {
        if (!$this->listaService->canBeDeleted($lista)) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.lista_contains_tasks')
            );
        }

        return $this->redirectToRoute('category_index');
        $form = $this->createForm(FormType::class, $lista, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('lista_delete', ['id' => $lista->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->listaService->delete($lista);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('lista_index');
        }

        return $this->render(
            'lista/delete.html.twig',
            [
                'form' => $form->createView(),
                'lista' => $lista,
            ]
        );
    }
}

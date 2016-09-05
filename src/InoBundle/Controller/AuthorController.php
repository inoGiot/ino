<?php

namespace InoBundle\Controller;

use InoBundle\Forms\AuthorForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Template()
 */
class AuthorController extends Controller
{
    public function indexAction()
    {
        $authors = $this->get('model.author')->getAllAuthors();

        return [
            'authors' => $authors,
        ];
    }

    public function editAction(Request $request, $id)
    {
        $authorModel = $this->get('model.author');
        $entity = $authorModel->getByIdOrEmpty($id);

        $form = $this->createForm(AuthorForm::class, $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $entity = $authorModel->save($form->getData());
            $this->addFlash('success', 'Author created');

            return $this->redirect(
                $this->generateUrl('authors_edit', [
                    'id' => $entity->getId(),
                ])
            );
        }

        return [
            'form' => $form->createView(),
        ];

    }

    public function deleteAction(Request $request)
    {
        $id = $request->request->getInt('id');
        $authorModel = $this->get('model.author');

        if ($id > 0) {
            $entity = $authorModel->find($id);
            $authorModel->delete($entity);

            return new JsonResponse([
               'code' => Response::HTTP_OK
            ]);
        }

        return new JsonResponse([
            'code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Author could not be found',
        ]);
    }
}

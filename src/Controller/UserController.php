<?php

/*
 * User Controller
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Manages user-related actions in the application.
 *
 * This controller provides functionality for authenticated users to manage their profiles. It handles tasks
 * such as editing a user's profile, including updating personal information and credentials. Access to its
 * methods is restricted based on the user's authentication status to ensure secure handling of user data.
 */
class UserController extends AbstractController
{
    /**
     * Handles the editing of the user profile.
     *
     * This method allows authenticated users to update their profile information.
     * It retrieves the currently logged-in user, initializes a form with the user's data, and processes the form submission.
     * If the form is valid, the user's data, including an optional new password, is updated using the user service.
     * A success message is added to the session upon successful update, and the user is redirected back to the same page.
     * Renders the profile editing template with the form view if the form is not submitted or is invalid.
     *
     * @param Request              $request     the request object containing form data
     * @param UserServiceInterface $userService service to handle user updates
     *
     * @return Response the HTTP response displaying the form view or redirecting after a successful update
     */
    #[Route('/profile/edit', name: 'user_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, UserServiceInterface $userService): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            $userService->updateUser($user, $plainPassword);

            $this->addFlash('success', 'Profile updated successfully!');

            return $this->redirectToRoute('user_edit');
        }

        return $this->render('User/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

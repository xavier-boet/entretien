<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        CategoryService $categoryMenuBuilder,
        UserRepository $userRepository,
        Security $security
    ): Response {
        $categoriesOptions = $categoryMenuBuilder->buildCategoryOptions();

        $users = $security->isGranted('ROLE_ADMIN')
            ? $userRepository->findUsersByDepartmentsOfCurrentUser($this->getUser())
            : [];

        return $this->render('home/index.html.twig', [
            'categoryOptions' => $categoriesOptions,
            'users' => $users
        ]);
    }
}

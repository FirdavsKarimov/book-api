<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class GetBooksByCategoryAction extends AbstractController
{

    public function __invoke(Request $request, BookRepository $bookRepository):array
    {
        $categoryId = $request->query->get('categoryId');
        $page = $request->query->get('page');

        if (!$categoryId) {
            throw new BadRequestException("Kategoriya id sini yuboring!!!");
        }

        return $bookRepository->findBy(['category' => (int)$categoryId], limit: 10, offset: --$page * 10);
    }

}
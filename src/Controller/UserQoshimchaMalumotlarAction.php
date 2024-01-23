<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\User\QoshimchaMalumotlarDto;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class UserQoshimchaMalumotlarAction extends AbstractController
{

    public function __invoke(#[MapRequestPayload] QoshimchaMalumotlarDto $qoshimchaMalumotlarDto)
    {
      return $qoshimchaMalumotlarDto;
    }
}
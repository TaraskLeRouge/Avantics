<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Campaigns
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get($id) {
        $campaignsRepository = $this->entityManager->getRepository(\App\Entity\Campaigns::class);
        return $campaignsRepository->get($id);
    }

    public function getAllCampaignsActiveNow() {
        $campaignsRepository = $this->entityManager->getRepository(\App\Entity\Campaigns::class);
        return $campaignsRepository->getAllCampaignsActiveNow();
    }
}
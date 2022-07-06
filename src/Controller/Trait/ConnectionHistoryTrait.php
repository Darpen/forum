<?php

namespace App\Controller\Trait;

use App\Entity\ConnectionHistory;
use DateTimeImmutable;
use DateTimeZone;
use Symfony\Component\HttpFoundation\Request;

Trait ConnectionHistoryTrait
{
    /**
     * @param Request $request
     * @return ConnectionHistory
     */
    protected function createConnectionHistory(Request $request): ConnectionHistory
    {
        $connectionHistory = new ConnectionHistory();
        $connectionHistory
            ->setUserIp($request->getClientIp())
            ->setCreatedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
        $this->em->persist($connectionHistory);
        return $connectionHistory;
    }
}
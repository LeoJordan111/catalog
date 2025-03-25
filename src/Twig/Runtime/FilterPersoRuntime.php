<?php

namespace App\Twig\Runtime;

use App\Repository\LeagueRepository;
use Twig\Extension\RuntimeExtensionInterface;
use Symfony\Component\HttpFoundation\Response;

class FilterPersoRuntime implements RuntimeExtensionInterface
{
    public function __construct(private LeagueRepository $leagueRepository)
    {
        // Inject dependencies if needed

    }

    public function euro(int $value): string
    {
        return $value . ' €';
    }

    public function league(): array
    {

        return $this->leagueRepository->findAll();
    }
}

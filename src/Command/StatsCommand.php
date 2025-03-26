<?php

namespace App\Command;

use App\Repository\ClubRepository;
use App\Repository\UserRepository;
use App\Repository\LeagueRepository;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:stats',
    description: 'Add a short description for your command',
)]
class StatsCommand extends Command
{
    public function __construct(
        private UserRepository $userRepository,
        private ClubRepository $clubRepository,
        private LeagueRepository $leagueRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $users = count($this->userRepository->findAll());
        $clubs = count($this->clubRepository->findAll());
        $leagues = $this->leagueRepository->findAll();
        $Array = [];


        foreach ($leagues as $league):
            $Array[] = $league->getLabel();
        endforeach;



        $io->success('Vous avez ' . $users . ' utilisateurs');
        $io->success('Vous avez ' . $clubs . ' clubs');
        $io->listing(
            $Array
        );
        // $io->success($leagues);
        // $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace App\Command;

use App\External\Easypack\EasypackHttpClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:dump-easypack-resource')]
class DumpEasypackResourceCommand extends Command
{
    public function __construct(private readonly EasypackHttpClient $easypackHttpClient)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Test the Easypack API by fetching data for a given city and resource.')
            ->addUsage('app:dump-easypack-resource points Kozy')
            ->addArgument('resource', InputArgument::REQUIRED, 'The name of the resource to fetch (e.g., points).')
            ->addArgument('city', InputArgument::REQUIRED, 'The name of the city to fetch data for.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $resource = $input->getArgument('resource');
        $city = $input->getArgument('city');

        if (empty($resource)) {
            $output->writeln('Please specify a resource name.');
            return Command::FAILURE;
        }

        if (empty($city)) {
            $output->writeln('Please specify a city name.');
            return Command::FAILURE;
        }

        try {
            $content = $this->easypackHttpClient->get($resource, ['city' => $city]);
            dump($content);
        } catch (\Exception $e) {
            $output->writeln('Error: '.$e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

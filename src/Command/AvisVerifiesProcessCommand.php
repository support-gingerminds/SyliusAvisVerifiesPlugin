<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Command;

use Ikuzo\SyliusAvisVerifiesPlugin\Processor\AvisVerifiesOrdersProcessorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class AvisVerifiesProcessCommand extends Command
{
    protected static $defaultName = 'ikuzo:avisverifies:process';

    protected $avisVerifiesOrdersProcessor;

    public function __construct(AvisVerifiesOrdersProcessorInterface $avisVerifiesOrdersProcessor) {
        $this->avisVerifiesOrdersProcessor = $avisVerifiesOrdersProcessor;
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->avisVerifiesOrdersProcessor->setLogger(new ConsoleLogger($output));
        $this->avisVerifiesOrdersProcessor->process();

        return Command::SUCCESS;
    }
}

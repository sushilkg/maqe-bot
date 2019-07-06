<?php namespace MaqeBot;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MaqeCommand extends MaqeBot
{

    public function configure()
    {
        $this->setName('start')
            ->setDescription('Starts the bot at 0, 0 position.')
            ->setHelp('Start is a default command that runs the MAQE Bot. It always starts from 0, 0 position. Since this is the default command, you do not need to specify it to use this command.')
            ->addArgument('command', InputArgument::REQUIRED, 'The command that MAQE Bot needs to follow. In a format of W5RW5RW2RW1R.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->start($input, $output);
    }
}
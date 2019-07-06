<?php namespace MaqeBot;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MaqeBot extends Command
{
    private const DIRECTIONS = ['NORTH', 'EAST', 'SOUTH', 'WEST'];

    private $positionX, $positionY, $directionFacing;

    public function __construct()
    {
        parent::__construct();

        $this->positionX       = 0;
        $this->positionY       = 0;
        $this->directionFacing = self::DIRECTIONS[0];
    }

    protected function start(InputInterface $input, OutputInterface $output)
    {
        $commands = $this->parseCommands($input->getArgument('command'));

        $this->startBot($commands);

        $output->writeln('X: '.$this->positionX.' Y: '.$this->positionY.' Direction: '.$this->directionFacing);
    }

    private function startBot(array $commands): void
    {
        foreach ($commands as $index => $command) {
            switch ($command) {
                case 'R':
                    $this->changeDirection('right');
                    break;
                case 'L':
                    $this->changeDirection('left');
                    break;
                case 'W':
                    $distanceToWalk = $commands[$index + 1];
                    $this->walk($distanceToWalk);
                    break;
            }
        }
    }

    private function parseCommands(string $command): array
    {
        $commands = $matches = [];

        preg_match_all('/(\d+|[a-zA-Z]+)/', $command, $matches);

        foreach ($matches[1] as $match) {
            if (!is_numeric($match)) {
                $match = str_split($match);
            } else {
                $match = [$match];
            }

            //expensive but we'll take care of this later
            $commands = array_merge($commands, $match);
        }

        return $commands;
    }

    private function changeDirection(string $direction): void
    {
        $currentDirectionIndex = array_search($this->directionFacing, self::DIRECTIONS, false);

        if ($direction === 'left') {
            $currentDirectionIndex--;
        } else {
            $currentDirectionIndex++;
        }


        $this->directionFacing = self::DIRECTIONS[$currentDirectionIndex % 4];
    }

    private function walk(int $distance): void
    {
        switch ($this->directionFacing) {
            case self::DIRECTIONS[0]: //north
                $this->positionY += $distance;
                break;
            case self::DIRECTIONS[2]: //south
                $this->positionY -= $distance;
                break;
            case self::DIRECTIONS[1]: //east
                $this->positionX += $distance;
                break;
            case self::DIRECTIONS[3]: //west
                $this->positionX -= $distance;
                break;
        }
    }
}
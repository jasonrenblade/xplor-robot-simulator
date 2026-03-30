<?php

namespace XplorRobotSimulator;

class Simulator
{
    private Robot $robot;

    public function __construct(?Robot $robot = null)
    {
        $this->robot = $robot ?? new Robot();
    }

    public function processLine(string $line): ?string
    {
        $line = trim($line);
        if ($line === '') {
            return null;
        }

        $parts = preg_split('/\s+/', strtoupper($line));
        if ($parts === false || count($parts) === 0) {
            return null;
        }

        $command = $parts[0];

        switch ($command) {
            case 'PLACE':
                if (count($parts) < 2) {
                    return null;
                }

                $args = explode(',', $parts[1]);
                if (count($args) !== 3) {
                    return null;
                }

                $x = filter_var($args[0], FILTER_VALIDATE_INT);
                $y = filter_var($args[1], FILTER_VALIDATE_INT);
                $f = $args[2];

                if ($x === false || $y === false) {
                    return null;
                }

                $this->robot->place((int)$x, (int)$y, $f);
                return null;
            case 'MOVE':
                $this->robot->move();
                return null;
            case 'LEFT':
                $this->robot->left();
                return null;
            case 'RIGHT':
                $this->robot->right();
                return null;
            case 'REPORT':
                return $this->robot->report();
            default:
                return null;
        }
    }

    public function run(array $commands): array
    {
        $reports = [];
        foreach ($commands as $line) {
            $report = $this->processLine($line);
            if ($report !== null) {
                $reports[] = $report;
            }
        }

        return $reports;
    }

    public function getRobot(): Robot
    {
        return $this->robot;
    }
}

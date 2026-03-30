<?php

namespace XplorRobotSimulator;

class Robot
{
    private const DIRECTIONS = ['NORTH', 'EAST', 'SOUTH', 'WEST'];

    private int $x;
    private int $y;
    private string $facing;
    private bool $isPlaced = false;

    public function __construct()
    {
        $this->x = 0;
        $this->y = 0;
        $this->facing = 'NORTH';
        $this->isPlaced = false;
    }

    public function place(int $x, int $y, string $facing): bool
    {
        $facing = strtoupper($facing);
        if (!in_array($facing, self::DIRECTIONS, true)) {
            return false;
        }

        if (!$this->isValidPoint($x, $y)) {
            return false;
        }

        $this->x = $x;
        $this->y = $y;
        $this->facing = $facing;
        $this->isPlaced = true;

        return true;
    }

    public function move(): void
    {
        if (!$this->isPlaced) {
            return;
        }

        $nextX = $this->x;
        $nextY = $this->y;

        switch ($this->facing) {
            case 'NORTH':
                $nextY++;
                break;
            case 'SOUTH':
                $nextY--;
                break;
            case 'EAST':
                $nextX++;
                break;
            case 'WEST':
                $nextX--;
                break;
        }

        if ($this->isValidPoint($nextX, $nextY)) {
            $this->x = $nextX;
            $this->y = $nextY;
        }
    }

    public function left(): void
    {
        if (!$this->isPlaced) {
            return;
        }

        $index = array_search($this->facing, self::DIRECTIONS, true);
        $this->facing = self::DIRECTIONS[($index + 3) % 4];
    }

    public function right(): void
    {
        if (!$this->isPlaced) {
            return;
        }

        $index = array_search($this->facing, self::DIRECTIONS, true);
        $this->facing = self::DIRECTIONS[($index + 1) % 4];
    }

    public function report(): ?string
    {
        if (!$this->isPlaced) {
            return null;
        }

        return sprintf('%d,%d,%s', $this->x, $this->y, $this->facing);
    }

    private function isValidPoint(int $x, int $y): bool
    {
        return $x >= 0 && $x <= 4 && $y >= 0 && $y <= 4;
    }

    public function isPlaced(): bool
    {
        return $this->isPlaced;
    }
}

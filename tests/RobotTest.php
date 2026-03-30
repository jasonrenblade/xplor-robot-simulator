<?php

namespace XplorRobotSimulator\Tests;

use PHPUnit\Framework\TestCase;
use XplorRobotSimulator\Robot;
use XplorRobotSimulator\Simulator;

class RobotTest extends TestCase
{
    public function testPlaceRejectsOutOfBounds()
    {
        $robot = new Robot();
        $this->assertFalse($robot->place(-1, 0, 'NORTH'));
        $this->assertFalse($robot->place(0, -1, 'NORTH'));
        $this->assertFalse($robot->place(5, 0, 'NORTH'));
        $this->assertFalse($robot->place(0, 5, 'NORTH'));
    }

    public function testMoveIgnoresUntilPlaced()
    {
        $robot = new Robot();
        $robot->move();
        $this->assertNull($robot->report());
    }

    public function testBasicMovementAndTurn()
    {
        $robot = new Robot();
        $robot->place(0, 0, 'NORTH');
        $robot->move();
        $this->assertEquals('0,1,NORTH', $robot->report());

        $robot->left();
        $this->assertEquals('0,1,WEST', $robot->report());

        $robot->right();
        $this->assertEquals('0,1,NORTH', $robot->report());
    }

    public function testPreventFallingOffTable()
    {
        $robot = new Robot();
        $robot->place(0, 0, 'SOUTH');
        $robot->move();
        $this->assertEquals('0,0,SOUTH', $robot->report());

        $robot->place(4, 4, 'NORTH');
        $robot->move();
        $this->assertEquals('4,4,NORTH', $robot->report());
    }

    public function testSimulatorExampleScenarios()
    {
        $simulator = new Simulator();

        $scenarioA = [
            'PLACE 0,0,NORTH',
            'MOVE',
            'REPORT',
        ];
        $this->assertEquals(['0,1,NORTH'], $simulator->run($scenarioA));

        $scenarioB = [
            'PLACE 0,0,NORTH',
            'LEFT',
            'REPORT',
        ];
        $this->assertEquals(['0,0,WEST'], $simulator->run($scenarioB));

        $scenarioC = [
            'PLACE 1,2,EAST',
            'MOVE',
            'MOVE',
            'LEFT',
            'MOVE',
            'REPORT',
        ];
        $this->assertEquals(['3,3,NORTH'], $simulator->run($scenarioC));
    }

    public function testReportWithoutPlaceReturnsNull()
    {
        $robot = new Robot();
        $this->assertNull($robot->report());
    }
}

# Xplor Toy Robot Simulator (PHP)

## Overview
This is a PHP implementation of the Toy Robot Simulator challenge.

- Table size: 5x5 (0..4,0..4)
- Commands: `PLACE X,Y,F`, `MOVE`, `LEFT`, `RIGHT`, `REPORT`
- Invalid placement, off-table moves, and commands before first valid placement are ignored.

## Requirements
- PHP 7.4+
- Composer
- PHPUnit (installed via composer)

## Install

```bash
cd path/to/xplor-robot-simulator
composer install
chmod +x bin/robot.php
```

## Run from file

Create a command file (e.g. `commands.txt`):

```text
PLACE 0,0,NORTH
MOVE
REPORT
```

Run:

```bash
php bin/robot.php commands.txt
```

## Run from stdin

```bash
cat commands.txt | php bin/robot.php
```

## PHPUnit tests

```bash
vendor/bin/phpunit
```

## Example

Input:
```text
PLACE 1,2,EAST
MOVE
MOVE
LEFT
MOVE
REPORT
```

Output:
```
3,3,NORTH
```

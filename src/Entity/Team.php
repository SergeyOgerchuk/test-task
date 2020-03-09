<?php

namespace App\Entity;

class Team
{
    private string $name;
    private string $country;
    private string $logo;
    /**
     * @var Player[]
     */
    private array $players;
    private string $coach;
    private int $goals;
    private int $goalkeeperPlayTime;
    private int $defenderPlayTime;
    private int $midfielderPlayTime;
    private int $forwardPlayTime;

    public function __construct(string $name, string $country, string $logo, array $players, string $coach)
    {
        $this->assertCorrectPlayers($players);

        $this->name = $name;
        $this->country = $country;
        $this->logo = $logo;
        $this->players = $players;
        $this->coach = $coach;
        $this->goals = 0;
        $this->goalkeeperPlayTime = 0;
        $this->defenderPlayTime = 0;
        $this->midfielderPlayTime = 0;
        $this->forwardPlayTime = 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return Player[]
     */
    public function getPlayersOnField(): array
    {
        return array_filter($this->players, function (Player $player) {
            return $player->isPlay();
        });
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayer(int $number): Player
    {
        foreach ($this->players as $player) {
            if ($player->getNumber() === $number) {
                return $player;
            }
        }

        throw new \Exception(
            sprintf(
                'Player with number "%d" not play in team "%s".',
                $number,
                $this->name
            )
        );
    }

    public function getGoalkeeperPlayTime():int {
        return $this->goalkeeperPlayTime;
    }

    public function getMidfielderPlayTime():int {
        return $this->midfielderPlayTime;
    }

    public function getDefenderPlayTime():int {
        return $this->defenderPlayTime;
    }

    public function getForwardPlayTime():int {
        return $this->forwardPlayTime;
    }

    public function calculateEveryPositionPlayTime(): void
    {
        foreach ($this->players as $player) {
            
            switch($player->getPosition()) {
                case "В":
                   $this->goalkeeperPlayTime += $player->getPlayTime();
                break;
                case "З":
                    $this->defenderPlayTime += $player->getPlayTime();
                break;
                case "П":
                    $this->midfielderPlayTime += $player->getPlayTime();
                break;
                case "Н":
                    $this->forwardPlayTime += $player->getPlayTime();
                break;
            }
        }
    }

    public function getCoach(): string
    {
        return $this->coach;
    }

    public function addGoal(): void
    {
        $this->goals += 1;
    }

    public function getGoals(): int
    {
        return $this->goals;
    }

    private function assertCorrectPlayers(array $players)
    {
        foreach ($players as $player) {
            if (!($player instanceof Player)) {
                throw new \Exception(
                    sprintf(
                        'Player should be instance of "%s". "%s" given.',
                        Player::class,
                        get_class($player)
                    )
                );
            }
        }
    }
}
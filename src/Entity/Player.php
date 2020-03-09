<?php
namespace App\Entity;

class Player
{
    private const PLAY_PLAY_STATUS = 'play';
    private const BENCH_PLAY_STATUS = 'bench';

    private int $number;
    private string $name;
    private string $position;
    private string $playStatus;
    private int $inMinute;
    private int $outMinute;
    private int $goals;
    private int $penaltyCards;

    public function __construct(int $number, string $name, string $position)
    {
        $this->number = $number;
        $this->name = $name;
        $this->position = $position;
        $this->playStatus = self::BENCH_PLAY_STATUS;
        $this->inMinute = 0;
        $this->outMinute = 0;
        $this->goals = 0;
        $this->penaltyCards = 0;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInMinute(): int
    {
        return $this->inMinute;
    }

    public function getOutMinute(): int
    {
        return $this->outMinute;
    }

    public function isPlay(): bool
    {
        return $this->playStatus === self::PLAY_PLAY_STATUS;
    }

    public function getPlayTime(): int
    {
        if (!$this->outMinute) {
            return 0;
        }

        if ($this->inMinute === 1) {
            return $this->outMinute;
        }

        return $this->outMinute - $this->inMinute;
    }

    public function getPosition():string
    {
        return $this->position;
    }

    public function addGoal():void
    {
        $this->goals ++;
    }

    public function getPlayerGoals():int
    {
        return $this->goals;
    }

    public function addPlayerPenaltyCards(int $card):void
    {
        $this->penaltyCards += $card;
    }

    public function getPlayerPenaltyCards():int
    {
        return $this->penaltyCards;
    }

    public function goToPlay(int $minute): void
    {
        $this->inMinute = $minute;
        $this->playStatus = self::PLAY_PLAY_STATUS;
    }

    public function goToBench(int $minute): void
    {
        $this->outMinute = $minute;
        $this->playStatus = self::BENCH_PLAY_STATUS;
    }
}

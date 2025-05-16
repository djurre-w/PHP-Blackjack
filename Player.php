<?php

class Player
{
    private string $name;
    private array $hand;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addCard(Card $card): string
    {
        $this->hand[] = $card;
        return $card->show();
    }

    public function showHand(): string
    {
        $text = '';
        foreach ($this->hand as $hand) {
            $text .= $hand->show() . ' ';
        }

        return $this->name . " has: " . $text;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function hand(): array
    {
        return $this->hand;
    }
}

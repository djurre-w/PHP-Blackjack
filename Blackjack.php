<?php

class Blackjack
{
    public function scoreHand(array $hand): string
    {
        $score = 0;

        foreach ($hand as $card) {
            $score += $card->score();
        }

        switch ($score) {
            case $score > 21:
                return "Busted!";
                break;
            case 21:
                return "Blackjack!";
                break;
            default:
                if (count($hand) >= 5) {
                    return "Five Card Charlie!";
                }
                return (string)$score;
                break;
        }
    }
}

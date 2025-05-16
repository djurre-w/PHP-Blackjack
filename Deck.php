<?php

class Deck
{
    private array $cards;

    public function __construct()
    {
        for ($y = 0; $y < 4; $y++) {
            switch ($y) {
                case 0:
                    $suit = "schoppen";
                    break;
                case 1:
                    $suit = "harten";
                    break;
                case 2:
                    $suit = "ruiten";
                    break;
                case 3:
                    $suit = "klaver";
                    break;
                default:
                    exit("error");
                    break;
            }
            for ($i = 0; $i < 13; $i++) {
                switch ($i) {
                    case 0:
                        $value = 'heer';
                        break;
                    case 1:
                        $value = 'vrouw';
                        break;
                    case 11:
                        $value = 'boer';
                        break;
                    case 12:
                        $value = 'aas';
                        break;
                    default:
                        $value = $i;
                        break;
                }

                $card = new card($suit, $value);
                $this->cards[] = $card;
            }
        }

        shuffle($this->cards);
    }

    function drawCard(): Card
    {
        if (empty($this->cards)) {
            exit("Deck is empty");
        }
        return array_pop($this->cards);
    }
}

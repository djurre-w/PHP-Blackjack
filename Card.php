<?php

class Card
{
    private string $suit;
    private string $value;

    private function validateSuit(string $suit): void
    {
        $suits = ['schoppen', 'harten', 'ruiten', 'klaver'];
        $and = false;

        foreach ($suits as $sui) {
            if ($suit == $sui) {
                $and = true;
                $this->suit = $suit;
            }
        }

        if ($and == false) {
            throw new InvalidArgumentException("invald suit: " . $suit);
        }
    }

    private function validateValue(string $value): void
    {
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'boer', 'vrouw', 'heer', 'aas'];
        $and = false;

        foreach ($values as $val) {
            if ($value == $val) {
                $and = true;
                $this->value = $value;
            }
        }

        if ($and == false) {
            throw new InvalidArgumentException("invald value: " . $value);
        }
    }

    public function __construct($suit, $value)
    {
        $this->validateValue($value);
        $this->validateSuit($suit);
    }

    public function show(): string
    {
        if (isset($this->suit) && isset($this->value)) {
            switch ($this->suit) {
                case 'klaver':
                    $suit = '♣';
                    break;
                case 'ruiten':
                    $suit = '♦';
                    break;
                case 'harten':
                    $suit = '♥';
                    break;
                case 'schoppen':
                    $suit = '♠';
                    break;

                default:
                    $suit = 0;
                    break;
            }

            switch ($this->value) {
                case 'boer':
                    $value = 'B';
                    break;
                case 'vrouw':
                    $value = 'V';
                    break;
                case 'heer':
                    $value = 'H';
                    break;
                case 'aas':
                    $value = 'A';
                    break;

                default:
                    $value = $this->value;
                    break;
            }

            return $suit . $value;
        } else {
            return " ";
        }
    }

    public function score(): int
    {
        switch ($this->value) {
            case 'boer':
            case 'vrouw':
            case 'heer':
                return 10;
                break;
            case 'aas':
                return 11;
                break;

            default:
                return (int)$this->value;
                break;
        }
    }
}

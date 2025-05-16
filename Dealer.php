<?php

class Dealer
{
    private Blackjack $blackjack;
    private Deck $deck;
    private array $players;
    private array $playerStops;
    private bool $gameStops = false;

    function __construct(Blackjack $blackjack, Deck $deck)
    {
        $this->blackjack = $blackjack;
        $this->deck = $deck;
        $this->playerStops = [];
        $this->players[] = new Player('Dealer');
    }

    function addPlayer(Player $player): void
    {
        $this->players[] = $player;
    }

    function playGame()
    {
        foreach ($this->players as $player) {
            for ($i = 0; $i < 2; $i++) {
                $player->addCard($this->deck->drawCard());
            }

            if ($this->blackjack->scoreHand($player->hand()) == "Blackjack!") {
                $this->gameStops = true;
                echo $player->name() . " Has won!!" . PHP_EOL;
            }
        }

        if ($this->gameStops == true) {
            foreach ($this->players as $player) {
                echo $player->showHand() . " -> " . $this->blackjack->scoreHand($player->hand()) . PHP_EOL;
            }
            exit;
        } else {
            do {
                if (count($this->playerStops) == count($this->players)) {
                    $this->gameStops = true;
                } else {
                    $this->dealMore();
                }
            } while ($this->gameStops == false);
            if ($this->gameStops == true) {
                $topscore = 0;
                $winners = [];
                foreach ($this->players as $player) {
                    $score = $this->blackjack->scoreHand($player->hand());

                    switch ($score) {
                        case "Blackjack!":
                            $winners = [$player->name()];
                            $topscore = "Blackjack!";
                            break;
                        case "Five Card Charlie!":
                            $winners = [$player->name()];
                            $topscore = "Five Card Charlie!";
                            break;
                        case is_numeric($score) && $score > $topscore && $score <= 21:
                            $topscore = $score;
                            $winners = [$player->name()];
                            break;
                        case is_numeric($score) && $score == $topscore && $score <= 21:
                            $winners[] = $player->name();
                            break;

                        default:
                            break;
                    }
                }
                if (!empty($winners)) {
                    echo "Winner(s): " . implode(', ', $winners) . " with score: $topscore" . PHP_EOL;
                } else {
                    echo "No winners this round." . PHP_EOL;
                }
                foreach ($this->players as $player) {
                    if (is_numeric($this->blackjack->scoreHand($player->hand()))) {
                    }
                    echo $player->showHand() . " -> " . $this->blackjack->scoreHand($player->hand()) . PHP_EOL;
                }
                exit;
            }
        }
    }

    private function dealMore()
    {
        foreach ($this->players as $player) {
            if ($player->name() == "Dealer") {
                if ($this->blackjack->scoreHand($player->hand()) < 18 && !isset($this->playerStops["Dealer"])) {
                    echo $player->showHand() . PHP_EOL;
                    echo $player->name() . " drew: " . $player->addCard($this->deck->drawCard()) . PHP_EOL;

                    switch ($this->blackjack->scoreHand($player->hand())) {
                        case "Blackjack!":
                            $this->gameStops = true;
                            echo $player->name() . " Has won!!" . PHP_EOL;
                            break;
                        case "Busted!":
                            $this->playerStops[$player->name()] = "Busted";
                            break;
                        case "Five Card Charlie!":
                            $this->gameStops = true;
                            echo $player->name() . " Has won!!" . PHP_EOL;
                            break;

                        default:
                            break;
                    }
                } else {
                    echo $player->showHand();
                    echo "Dealer Foldes" . PHP_EOL;
                    $this->playerStops[$player->name()] = "Folded";
                }
            } else {
                if (!isset($this->playerStops[$player->name()])) {
                    $and = readline($player->name() . "'s turn. You have: " . $player->showHand() . " Draw (D) or Stop (S): ");
                    $inputCheck = $this->checkInput($and, $player);
                    do {
                        if ($inputCheck != true) {
                            $and = readline($player->name() . "'s turn. You have: " . $player->showHand() . " Draw (D) or Stop (S): ");
                            $inputCheck = $this->checkInput($and, $player);
                        }
                    } while ($inputCheck != true);
                }
            }
        }
    }

    private function checkInput($input, $player)
    {
        if (strtoupper($input) == "D") {
            echo $player->name() . " drew: " . $player->addCard($this->deck->drawCard()) . PHP_EOL;

            switch ($this->blackjack->scoreHand($player->hand())) {
                case "Blackjack!":
                    $this->gameStops = true;
                    echo $player->name() . " Has won!!" . PHP_EOL;
                    return true;
                    break;
                case "Busted!":
                    $this->playerStops[$player->name()] = "Busted";
                    return true;
                    break;
                case "Five Card Charlie!":
                    $this->gameStops = true;
                    echo $player->name() . " Has won!!" . PHP_EOL;
                    return true;
                    break;

                default:
                    return true;
                    break;
            }
        } else if (strtoupper($input) == "S") {
            $this->playerStops[$player->name()] = "Folded";
            return true;
        } else {
            echo strtoupper($input) . " is not a valid input!" . PHP_EOL;
            return false;
        }
    }
}

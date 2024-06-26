<?php

class Test {
  
    public static function DT (int $idx1, int $idx2, array $drawNumber): string {
        $drawNumber = explode(",", implode(",", $drawNumber));
        $v1 = $drawNumber[$idx1];
        $v2 = $drawNumber[$idx2];
        return ($v1 > $v2) ? "Dragon" : (($v1 == $v2) ? "Tie" : "Tiger");
    }

    public static function GetBalls(string $gameId): string {
        $data = [
            '11' => 1, 
            '12' => 2, 
            '13' => 3, 
            '14' => 4, 
            '15' => 5,
            '16' => 3, 
            '17' => 7, 
            '18' => 8, 
            '19' => 9, 
            '20,26' => 10
        ];
        $found = [];
        foreach (array_keys($data) as $key) {
           if (in_array($gameId, explode(',',$key))) {
             $found[] = $data[$key];
           }
        }
        
        return count($found) == 0 ? 9999 : implode('',$found);
    }

    public static function Dragon (array $selection, array $drawNumber) {

        $gameId = $selection[1];
        $ball = intval(self::GetBalls($gameId)) - 1;
       
        $data = [
         
            '10' => self::DT(0, 9, $drawNumber) == $selection[0],
            '11' => self::DT(1, 8, $drawNumber) == $selection[0],
            '12' => self::DT(2, 7, $drawNumber) == $selection[0],
            '13' => self::DT(3, 6, $drawNumber) == $selection[0],
            '15' => self::DT(4, 5, $drawNumber) == $selection[0],
            '16,17,18,19,20' => ($drawNumber[$ball] > 5 && $selection[0] == 'Big') ? true : (($drawNumber[$ball] < 6 && $selection[0] == 'Small') ? true : false),
            '26,27,28,29,30' => ($drawNumber[$ball] % 2 != 0 && $selection[0] == 'Odd') ? true : (($drawNumber[$ball] % 2 == 0 && $selection[0] == 'Even') ? true : false),
        ];

        foreach (array_keys($data) as $key) {
            if (in_array($gameId, explode(',',$key))) {
                return $data[$key];
            }
        }
       // return false;
    }
}

var_dump(Test::Dragon(['Small',16],[1,2,3,4,5,8,9,7,10,6]));

<?php

trait Filter {

    public static function validateData($data, $validationRules)  {
    
        // Decode the JSON data
        $decodedData = json_decode($data, true);
    
        // Check if the data is a valid JSON array
        if (!is_array($decodedData)) return false;
    
        foreach ($decodedData as $item) {
    
            // Check if all keys exist in the item
            if(!empty(array_diff(array_keys($validationRules), array_keys($item)))) return false;

            // Validate each key based on the validation rules
            foreach ($validationRules as $key => $rule) {
                if (isset($item[$key])) {
                    $value = $item[$key];
                    $type = $rule['type'];
                    $format = $rule['format'];
    
                    // Check type
                    if (validateType($value, $type)) return true;
    
                    // Check format
                    if (!validateFormat($value, $format)) return true;
                }
            }
        }
    
        return false;
    }
    
    public static function validateType($value, $type)  {
        switch ($type) {
            case 'int':
                return is_int($value);
            case 'string':
                return is_string($value);
            case 'array':
                return is_array($value);
            default:
                return true; // Assume valid for unknown types
        }
    }
    
    public static function validateFormat($value, $format)  {

        $pattern = '/\[((?:\'.*?\'|".*?"))\]/s';
        switch ($format) {
            case 'string':
                return preg_match($pattern, $value);
            default:
                return false; // Assume valid for unknown formats
        }
    }

    public static function validationRules()  {

        $validationRules = [ // validation rules
            "betId"          =>  ['type'  =>  'string',  'format'  =>  'string'], 
            "allSelections"  =>  ['type'  =>  'array',   'format'  =>  'string'],
            "totalBetAmt"    =>  ['type'  =>  'int',     'format'  =>  'string'],
            "uid"            =>  ['type'  =>  'int',     'format'  =>  'string'],
            "bet_date"       =>  ['type'  =>  'string',  'format'  =>  'string'],
            "bet_time"       =>  ['type'  =>  'string',  'format'  =>  'string'], 
            "game_label"     =>  ['type'  =>  'string',  'format'  =>  'string'],
            "totalBets"      =>  ['type'  =>  'int',     'format'  =>  'string'],
            "lottery_id"     =>  ['type'  =>  'int',     'format'  =>  'string'],
            "unitStaked"     =>  ['type'  =>  'int',     'format'  =>  'string'],
            "multiplier"     =>  ['type'  =>  'int',     'format'  =>  'string'],
            "gameId"         =>  ['type'  =>  'int',     'format'  =>  'string'],
            "userSelections" =>  ['type'  =>  'string',  'format'  =>  'string']
        ];

        return $validationRules;
    }

}

//var_dump(Filter::validate());


<?php
function validateData($data, $validationRules)
{
    $errors = [];

    // Decode the JSON data
    $decodedData = json_decode($data, true);

    // Check if the data is a valid JSON array
    if (!is_array($decodedData)) {
        $errors[] = 'Invalid JSON data';
        return $errors;
    }

    foreach ($decodedData as $item) {
        $itemErrors = [];

        // Check if all keys exist in the item
        $missingKeys = array_diff(array_keys($validationRules), array_keys($item));
        if (!empty($missingKeys)) {
            $itemErrors[] = 'Missing keys: ' . implode(', ', $missingKeys);
        }

        // Validate each key based on the validation rules
        foreach ($validationRules as $key => $rule) {
            if (isset($item[$key])) {
                $value = $item[$key];
                $type = $rule['type'];
                $format = $rule['format'];

                // Check type
                if (!validateType($value, $type)) {
                    $itemErrors[] = "$key should be of type $type";
                }

                // // Check format
                // if (!validateFormat($value, $format)) {
                //     $itemErrors[] = "$key has an invalid format";
                // }
            }
        }

        if (!empty($itemErrors)) {
            $errors[] = [
                'item' => $item,
                'errors' => $itemErrors,
            ];
        }
    }

    return $errors;
}

function validateType($value, $type)
{
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

function validateFormat($value, $format)
{
    switch ($format) {
        case 'string':
            return is_string($value);
        default:
            return true; // Assume valid for unknown formats
    }
}

// Example usage
$validationRules = [
    "betId" => ['type' => 'string', 'format' => 'string'],
    "allSelections" => ['type' => 'array', 'format' => 'string'],
    "totalBetAmt" => ['type' => 'int', 'format' => 'string'],
    "uid" => ['type' => 'int', 'format' => 'string'],
    "bet_date" => ['type' => 'string', 'format' => 'string'],
    "bet_time" => ['type' => 'string', 'format' => 'string'],
    "game_label" => ['type' => 'string', 'format' => 'string'],
    "totalBets" => ['type' => 'int', 'format' => 'string'],
    "lottery_id" => ['type' => 'int', 'format' => 'string'],
    "unitStaked" => ['type' => 'int', 'format' => 'string'],
    "multiplier" => ['type' => 'int', 'format' => 'string'],
    "gameId" => ['type' => 'int', 'format' => 'string'],
    "userSelections" => ['type' => 'string', 'format' => 'string']
];

$data = "[{\"betId\":\"202403131132\",\"allSelections\":[\"Big\"],\"totalBetAmt\":2,\"uid\":1,\"bet_date\":\"2024-03-13\",\"bet_time\":\"11:50:25\",\"game_label\":\"Sum Big/Small\",\"totalBets\":1,\"lottery_id\":\"10\",\"unitStaked\":1,\"multiplier\":2,\"gameId\":1148,\"userSelections\":\"Sum Big/Small Big\"},{\"betId\":\"202403131132\",\"allSelections\":[\"Small\"],\"totalBetAmt\":2,\"uid\":2,\"bet_date\":\"2024-03-13\",\"bet_time\":\"11:50:25\",\"game_label\":\"Sum Big/Small\",\"totalBets\":1,\"lottery_id\":\"10\",\"unitStaked\":1,\"multiplier\":2,\"gameId\":1148,\"userSelections\":\"Sum Big/Small Small\"}]";

$errors = validateData($data, $validationRules);

if (!empty($errors)) {
    // Handle validation errors
    echo '<pre>';
    print_r($errors);
} else {
    // Data is valid, proceed with database operation
    echo "Data is valid";
}
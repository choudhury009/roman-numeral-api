<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\NumberResource;
use App\Models\Number;
use Illuminate\Support\Facades\DB;

/**
 * A controller to convert integers to roman numerals.
 *
 * Class RomanNumeralController
 * @package App\Http\Controllers\Api
 */
class RomanNumeralController
{
    /**
     * Convert the number to a roman numeral.
     *
     * @param int $number
     *
     * @return string
     */
    public function numberToNumeral(int $number): string
    {
        if ($number < 1 || $number > 3999) {
            return response()->json([
                'success' => false,
                'message' => 'Value needs to range from 1 - 3999'
            ], 400);
        }

        $map = [
            'M'  => 1000,
            'CM' => 900,
            'D'  => 500,
            'CD' => 400,
            'C'  => 100,
            'XC' => 90,
            'L'  => 50,
            'XL' => 40,
            'X'  => 10,
            'IX' => 9,
            'V'  => 5,
            'IV' => 4,
            'I'  => 1
        ];

        $originalNumber = $number;
        $numeral = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $numeral .= $roman;
                    break;
                }
            }
        }

        $findNumber = Number::where('number', $originalNumber)->first();

        if ($findNumber) {
            $findNumber->update([
                'count' => $findNumber->count + 1
            ]);
        } else {
            $numberObj = new Number();
            $numberObj->number = $originalNumber;
            $numberObj->numeral = $numeral;
            $numberObj->count = 1;
            $numberObj->save();
        }

        return response()->json([
            'success' => true,
            'data' => $numeral
        ], 200);
    }

    /**
     * Lists all the recently converted integers.
     */
    public function recentlyConverted()
    {
        $numbers = Number::orderBy('id', 'desc')->get();
        $data = NumberResource::collection($numbers);

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    /**
     * Lists the top 10 converted integers.
     */
    public function topTenConverted()
    {
        $numbers = Number::orderBy('count', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $numbers
        ], 200);
    }
}

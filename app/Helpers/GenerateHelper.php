<?php

use App\Models\Transactions;

class GenerateHelper {

	public static function generateCode(){
        do {
            $str = strtoupper(str_random(5));

            $checkUnique = Transactions::where('id_trans', $str)->count();

        } while ($checkUnique > 0);

        return $str;
	}

}
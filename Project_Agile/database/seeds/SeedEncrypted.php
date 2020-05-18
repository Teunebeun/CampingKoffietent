<?php

use Illuminate\Support\Facades\App;

trait SeedEncrypted {
    public function seed($className, $data) {

        foreach ($data as $row) {
            $record = App::make($className);

            for($i = 0; $i < sizeof($record->getFillable()); $i++) {
                $fillable = $record->getFillable()[$i];
                $record->$fillable = $row[$i];
            }

            $record->save();
        }
    }
}



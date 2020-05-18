<?php

namespace App;

use Illuminate\Support\Facades\Crypt;

trait EncryptAttributes
{
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            $value = Crypt::encrypt($value);
        }

        parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encryptable)) {
            $value = Crypt::decrypt($this->attributes[$key]);
        }
        return $value;
    }
}

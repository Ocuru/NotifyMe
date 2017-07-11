<?php

namespace Ocuru\Notify;

class Common
{
    public static function setNEmpty($data, $key)
    {
        if (isset($data[$key])) {
            if (!empty($data[$key])) {
                return true;
            }

            return false;
        }

        return false;
    }
}

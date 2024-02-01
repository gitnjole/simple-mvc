<?php

namespace app\core;

class Session 
{
    protected const FLASH_KEYWORD = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMesages = $_SESSION[self::FLASH_KEYWORD] ?? [];
        foreach ($flashMesages as $key => &$flashMesage) {
            $flashMesage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEYWORD] = $flashMesages;
    }

    public function __destruct()
    {
        $flashMesages = $_SESSION[self::FLASH_KEYWORD] ?? [];
        foreach ($flashMesages as $key => &$flashMesage) {
            if ($flashMesage['remove']) {
                unset($flashMesages[$key]);
            }
        }

        $_SESSION[self::FLASH_KEYWORD] = $flashMesages;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function setFlashMessage($keyword, $message)
    {
        $_SESSION[self::FLASH_KEYWORD][$keyword] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlashMessage($keyword)
    {
        return $_SESSION[self::FLASH_KEYWORD][$keyword]['value'] ?? false;
    }
}
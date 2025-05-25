<?php

class Bot {
    private static $token;

    public static function setToken($token) {
        self::$token = $token;
    }

    public static function __callStatic($method, $params) {
        $data = $params[0] ?? [];
        $url = "https://api.telegram.org/bot" . self::$token . "/$method";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res, true);
    }
}

class Api {
    public static function request($method, $url, $data = []) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } elseif (strtoupper($method) === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res, true);
    }
}

class Telegram {
    public static $update;
    public static $chatid;
    public static $command;

    public static function init() {
        self::$update  = json_decode(file_get_contents('php://input'), true);
        self::$chatid  = self::$update['message']['chat']['id']
                      ?? self::$update['callback_query']['message']['chat']['id']
                      ?? null;

        self::$command = self::$update['message']['text']
                      ?? self::$update['callback_query']['data']
                      ?? null;

        // Optional: Define global vars for legacy support
        $GLOBALS['update']  = self::$update;
        $GLOBALS['chatid']  = self::$chatid;
        $GLOBALS['command'] = self::$command;
    }

    public static function __getStatic($name) {
        return self::$$name ?? null;
    }

    public static function __get($name) {
        return self::$$name ?? null;
    }

    public static function __callStatic($name, $args) {
        return self::$$name ?? null;
    }
}

Telegram::init(); // Automatically loads $update, $chatid, $command

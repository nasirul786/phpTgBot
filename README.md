**Telegram.php – Simple PHP Library for Telegram Bots**

**Overview**
Telegram.php is a lightweight and dependency-free PHP library for building Telegram bots. It supports dynamic API calls, auto-parses updates, and exposes helpful global variables. Designed for reuse across multiple bots with minimal setup.

---

**Features**

* Dynamic Telegram Bot API access using `Bot::method([...])`
* Automatically parses Telegram updates
* Automatically sets:

  * `$update` – full update array
  * `$chatid` – the chat ID (from message or callback)
  * `$command` – message text or callback data
* Built-in HTTP request system using `Api::request(...)`
* No Composer or external dependencies
* Ideal for multi-bot architecture (central reusable core)

---

**Usage**

1. Include the library:

   `require 'Telegram.php';`

2. Set your bot token:

   `Bot::setToken('YOUR_BOT_TOKEN');`

3. Use predefined variables:

   * `Telegram::chatid` – chat ID of the sender
   * `Telegram::command` – message text or callback data
   * `Telegram::update` – full Telegram update payload

4. Example usage:

   ```php
   switch (Telegram::command) {
       case '/start':
           Bot::sendMessage([
               'chat_id' => Telegram::chatid,
               'text' => 'Welcome to the bot!'
           ]);
           break;

       case 'ping':
           Bot::sendMessage([
               'chat_id' => Telegram::chatid,
               'text' => 'pong'
           ]);
           break;
   }
   ```

---

**External API Request**

You can use the built-in API system:

Example:

`Api::request("POST", "https://example.com/api", ['key' => 'value']);`

Supports both GET and POST methods.

---

**Available Global Variables**

* `$update` – Full Telegram update (array)
* `$chatid` – User's chat ID
* `$command` – Message text or callback query data

These are globally defined for quick access, and also accessible via:

* `Telegram::update`
* `Telegram::chatid`
* `Telegram::command`

---

**License**

MIT License – Free to use, modify, and distribute.

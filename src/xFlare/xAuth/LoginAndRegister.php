<?php

#Controls logins and registers.
namespace xFlare\xAuth;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\event\player\PlayerChatEvent;

/*
- 2 = Registered. (Implementing later...)
- 1 = Logged in.
- 0 = Not logged in or registered.
*/

class LoginAndRegister implements Listener{
	public function __construct(Loader $plugin){
        $this->plugin = $plugin;
    }
    public function onChat(PlayerChatEvent $event){
        if($this->owner->status === "enabled"){
            if($this->owner->provider === "yml"){
                //Manage login/register for provider.
            }
            elseif($this->owner->provider === "mysql"){
                //Manage login/register for provider.
            }
        }
    }
}


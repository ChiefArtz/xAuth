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
use pocketmine\event\player\PlayerJoinEvent;

/*
- 2 = Registered. (Implementing later...)
- 1 = Logged in.
- 0 = Not logged in or registered.
*/

class LoginAndRegister implements Listener{
	public function __construct(Loader $plugin){
        $this->plugin = $plugin;
    }
    public function onJoin(PlayerJoinEvent $event){
        if($this->owner->status === "enabled"){
            $this->owner->loginmanager[$event->getPlayer()->getId()] = 0;
        }
    }
    public function onChat(PlayerChatEvent $event){
        if($this->owner->status === "enabled" and $this->owner->loginmanager[$event->getPlayer()->getId()] === 0){
            if($this->owner->provider === "yml"){
                //Manage login/register for provider.
            }
            elseif($this->owner->provider === "mysql"){
                //Manage login/register for provider.
            }
        }
    }
}


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
        if($this->owner->status === "enabled" && $this->owner->getConfig()->get("ip-auth") !== true){
            $this->owner->loginmanager[$event->getPlayer()->getId()] = 0;
        }
        elseif($this->owner->status === "enabled" && $this->owner->getConfig()->get("ip-auth") === true){
        	$myuser = new Config($this->myuser . "users/" . strtolower($event->getPlayer()->getName() . ".yml"), Config::YAML);
        	if($myuser->get("myip") !=== $event->getPlayer()->getAddress()){
        		$event->getPlayer()->sendMessage("[xAuth] Your IP does not match.");
        		$event->getPlayer()->sendMessage("[xAuth] Please type your password in chat.");
        		return true;
        	}
        	else{
        		$this->chatmanager[$event->getPlayer()->getId()] = 1;
        		$event->getPlayer()->sendMessage("[xAuth] You are now logged-in.");
        		
        	}
        }
    }
    public function onChat(PlayerChatEvent $event){
        if($this->owner->status === "enabled" and $this->owner->loginmanager[$event->getPlayer()->getId()] !== 1){
            if($this->owner->provider === "yml"){
                //Manage login/register for provider.
            }
            elseif($this->owner->provider === "mysql"){
                //Manage login/register for provider.
            }
        }
    }
}


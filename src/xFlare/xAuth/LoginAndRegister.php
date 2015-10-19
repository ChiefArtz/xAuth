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
    	if($this->owner->status === "enabled" and $this->provider === "yml"){
        	if($this->owner->getConfig()->get("ip-auth") !== true){
            		$this->owner->loginmanager[$event->getPlayer()->getId()] = 0;
        	}
        	if($this->owner->getConfig()->get("ip-auth") === true){
        		$myuser = new Config($this->myuser . "users/" . strtolower($event->getPlayer()->getName() . ".yml"), Config::YAML);
        		if($myuser->get("registered") !== true){
        			$this->owner->proccessmanager[$event->getPlayer()->getId()] = 0;
        			return true;
        		}
        	}
        	if($myuser->get("myip") !=== $event->getPlayer()->getAddress()){
        		$event->getPlayer()->sendMessage("[xAuth] Your IP does not match.");
        		$event->getPlayer()->sendMessage("[xAuth] Please type your password in chat.");
        	}
        	else{
        		$this->chatmanager[$event->getPlayer()->getId()] = 1;
        		$event->getPlayer()->sendMessage("[xAuth] You are now logged-in.");
        	}
    	}
    	elseif($this->owner->status === "enabled"){
    		//MySQL
    	}
    }
    public function onChat(PlayerChatEvent $event){
        if($this->owner->status === "enabled" and $this->owner->loginmanager[$event->getPlayer()->getId()] !== 1){
            if($this->owner->provider === "yml"){
            	if($this->owner->loginmanager[$event->getPlayer()->getId()] === 0){
            		$event->getPlayer()->sendMessage("Thanks! Please re-type your wanted password in chat.");
            		$this->owner->loginmanager[$event->getPlayer()->getId()] = $message;
            		
            	}
            	elseif($this->owner->loginmanager[$event->getPlayer()->getId()] === $message){
            		$this->proccessPassword($message, 0);
            		$event->getPlayer()->sendMessage("You are now registered.");
            		unset $this->owner->proccessmanager[$event->getPlayer()->getId()];
            	}
            }
            elseif($this->owner->provider === "mysql"){
                //Manage login/register for provider.
            }
        }
        else{
        	$ecr = $this->proccessPassword($event->getMessage(), 1);
        	if($myuser->get("password") === $ecr){
        		$event->getPlayer()->sendMessage("You are now logged in.");
        	}
        	else{
        		$event->getPlayer()->sendMessage("Login failed.");
        	}
        }
    }
    private function proccessPassword($password, $type){
    	$myuser = new Config($this->myuser . "users/" . strtolower($event->getPlayer()->getName() . ".yml"), Config::YAML);
    	if($type === 0){
    		$myuser->set("password", hash("xauth", strtoupper($password)));
    		$myuser->save();
    		
    	}
    	else{
    		return hash("xauth", strtoupper($password));
    		
    	}
    }
}


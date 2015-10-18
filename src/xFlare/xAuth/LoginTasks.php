<?php

#Stops people from doing stuff, when not logged in.
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;

/*
- 2 = Registered. (Implementing later...)
- 1 = Logged in.
- 0 = Not logged in.
*/

class LoginTasks implements Listener{
	public function __construct(Loader $plugin){
        $this->plugin = $plugin;
    }
    public function onChat(PlayerChatEvent $event){
    	if($this->owner->status = "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId] === 0){
    		$event->setCancelled(true);
    	}
    	elseif($this->owner->status = "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId] === 1 && $this->owner->chatprotection[$event->getPlayer()->getId] !== $message){
    		$event->setCancelled(true); //Sharing is caring, but don't share passwords!
    	}
    }
    public function onJoin(PlayerJoinEvent $event){
    	$this->owner->loginmanager[$event->getPlayer()->getId()] = 0;
    }
}


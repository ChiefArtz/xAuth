<?php
/*
                            _     _     
            /\             | |   | |    
 __  __    /  \     _   _  | |_  | |__  
 \ \/ /   / /\ \   | | | | | __| | '_ \ 
  >  <   / ____ \  | |_| | | |_  | | | |
 /_/\_\ /_/    \_\  \__,_|  \__| |_| |_|
                                        
                                        */

#Stops people from doing stuff, when not logged in or registered.
namespace xFlare\xAuth;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
//Events\\
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;

/*
- 2 = Registered. (Implementing later...)
- 1 = Logged in.
- 0 = Not logged in or registered.
*/

class LoginTasks implements Listener{
	public function __construct(Loader $plugin){
        $this->plugin = $plugin;
        $this->message = "Please authenticate to play!";
        $this->disable = "xAuth is disabled at this moment.";
    }
    public function onChat(PlayerChatEvent $event){
    	$message = $event->getMessage();
    	if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getPlayer()->getId()] === 0 && $this->plugin->chatprotection[$event->getPlayer()->getId()] === $this->plugin->proccessPassword($message, 1)){
    		$event->setCancelled(true); //Sharing is caring, but don't share passwords!
    	}
    	elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
    		$event->setCancelled(true);
    	}
    }
    public function onDrop(PlayerDropItemEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getPlayer()->getId()] === 0){
            $event->setCancelled(true);
        }
        elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
    		$event->setCancelled(true);
    	}
    }
    public function onCommand(PlayerCommandPreprocessEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getPlayer()->getId()] === 0 && $this->plugin->allowCommand !== true && substr($event->getMessage(), 0, 1) === '/'){ 
            $event->setCancelled(true);
        }
        elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
    		$event->setCancelled(true);
    	}
    }
    public function onInteract(PlayerInteractEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getPlayer()->getId()] === 0){
            $event->setCancelled(true);
        }
        elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
    		$event->setCancelled(true);
    	}
    }
    public function onMove(PlayerMoveEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getPlayer()->getId()] === 0 && $this->plugin->allowMoving !== true){
            $event->setCancelled(true);
        }
        elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
    		$event->setCancelled(true);
    	}
    }
    public function onBreak(BlockBreakEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getPlayer()->getId()] === 0 && $this->plugin->allowBreak !== true){
            $event->setCancelled(true);
        }
        elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
    		$event->setCancelled(true);
    	}
    }
    public function onPlace(BlockPlaceEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getPlayer()->getId()] === 0 && $this->plugin->allowPlace !== true){
            $event->setCancelled(true);
        }
        elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
    		$event->setCancelled(true);
    	}
    }
    public function onPvP(EntityDamageEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getEntity()->getId()] === 0){
            $event->setCancelled(true);
        }
        elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
            $event->setCancelled(true);
        }
    } 
    public function onBowShoot(EntityShootBowEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getEntity()->getId()] === 0){
            $event->setCancelled(true);
        }
        elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
    		$event->setCancelled(true);
    	}
    }
    public function onFoodEat(PlayerItemConsumeEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->loginmanager[$event->getEntity()->getId()] === 0){
            $event->setCancelled(true);
        }
        elseif($this->plugin->safemode === true and $this->plugin->status !== "enabled"){
    		$event->setCancelled(true);
    	}
    }
    public function onJoin(PlayerJoinEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->getConfig()->get("player-join") !== true){
            $event->setJoinMessage("");
        }
    }
    public function onQuit(PlayerQuitEvent $event){
        if($this->plugin->status === "enabled" && $this->plugin->getConfig()->get("player-quit") !== true){
            $event->setQuitMessage("");
        }
    }
}


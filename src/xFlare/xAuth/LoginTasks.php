<?php

#Stops people from doing stuff, when not logged in.
namespace xFlare\xAuth;

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
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
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
    }
    public function onChat(PlayerChatEvent $event){
    	if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId()] === 0){
    		$event->setCancelled(true);
    	}
    	elseif($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId()] === 1 && $this->owner->chatprotection[$event->getPlayer()->getId] === $message){
    		$event->setCancelled(true); //Sharing is caring, but don't share passwords!
    	}
    }
    public function onDrop(PlayerDropItemEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId()] === 0){
            $event->setCancelled(true);
        }
    }
    public function onCommand(PlayerCommandPreprocessEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId()] === 0){
            $event->setCancelled(true);
        }
    }
    public function onInteract(PlayerInteractEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId()] === 0){
            $event->setCancelled(true);
        }
    }
    public function onMove(PlayerInteractEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId()] === 0 && $this->owner->getConfig()->get("allow-movment") !== true){
            $event->setCancelled(true);
        }
    }
    public function onBreak(BlockBreakEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId()] === 0){
            $event->setCancelled(true);
        }
    }
    public function onPlace(BlockPlaceEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getPlayer()->getId()] === 0){
            $event->setCancelled(true);
        }
    }
    public function onPvP(EntityDamageByEntityEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getEntity()->getId()] === 0){
            $event->setCancelled(true);
        }
    }
    public function onBowShoort(EntityShootBowEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getEntity()->getId()] === 0){
            $event->setCancelled(true);
        }
    }
    public function onBowShoort(EntityShootBowEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getEntity()->getId()] === 0){
            $event->setCancelled(true);
        }
    }
    public function onFoodEat(PlayerItemConsumeEvent $event){
        if($this->owner->status === "enabled" && $this->owner->loginmanager[$event->getEntity()->getId()] === 0){
            $event->setCancelled(true); //PlayerItemConsumeEvent;
        }
    }
    public function onJoin(PlayerJoinEvent $event){
        if($this->owner->status === "enabled" && $this->owner->getConfig()->get("player-join") !== true){
            $this->setJoinMessage("");
            $event->setCancelled(true);
        }
    }
    public function onJoin(PlayerJoinEvent $event){
        if($this->owner->status === "enabled" && $this->owner->getConfig()->get("player-quit") !== true){
            $this->setQuitMessage("");
            $event->setCancelled(true);
        }
    }
}


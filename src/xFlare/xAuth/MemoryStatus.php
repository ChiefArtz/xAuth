<?php

#Helps servrer stay alive if it is laging.
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;

class MemoryTasks implements Listener{
	public function __construct(Loader $plugin){
        $this->plugin = $plugin;
    }
    public function onRun($currentTick){
    	if($this->getServer()->getTicksPerSecond() < 12){
    		$this->owner->getLogger("> Warning, Server is overloaded! xAuth quries may take longer!\n> xAuth will try to reduce it's activity.");
    		$this->owner->memorymanagerdata++; //The more it adds, the more xAuth will reduce it's inimportant activity.
    	}
    	elseif($this->memorymanagerdata !== 0){
    		$this->owner->memeorymanagerdata = $this->memeorymanagerdata - 1;
    	}
    }
}
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
    		$this->owner->getLogger("> Warning, Server is overloaded! xAuth quries may take longer!");
    	}
    }
}
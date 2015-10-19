<?php

#Helps server stay alive if it is laging.
namespace xFlare\xAuth;

use pocketmine\scheduler\PluginTask;
use pocketmine\Server;

class MemoryStatus extends PluginTask{
	public function __construct(Loader $plugin){
        $this->plugin = $plugin;
    }
    public function onRun($currentTick){
        if($this->owner->status === "enabled"){
    	   if($this->getServer()->getTicksPerSecond() < 12){
    		  $this->owner->getLogger("> Warning, Server is overloaded! xAuth quries may take longer!\n> xAuth will try to reduce it's activity.");
    		  $this->owner->memorymanagerdata = 1;
    	   }
           elseif($this->memorymanagerdata !== 0){
           	$this->owner->memeorymanagerdata = 0;
           }
        }
    }
}

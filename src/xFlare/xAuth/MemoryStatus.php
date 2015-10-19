<?php

#Helps server stay alive if it is laging.
namespace xFlare\xAuth;

use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
class MemoryStatus extends PluginTask{
    public function __construct(Loader $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->length = -1;
    }
    public function onRun($currentTick){
        if($this->owner->status === "enabled"){
    	   if($this->owner->getServer()->getTicksPerSecond() < 12){
    		  $this->owner->getLogger("> Warning, Server is overloaded! xAuth quries may take longer!\n> xAuth will try to reduce it's activity.");
    		  $this->owner->memorymanagerdata = 1;
    	   }
           elseif($this->owner->memorymanagerdata !== 0){
           	$this->owner->memeorymanagerdata = 0;
           }
        }
    }
}

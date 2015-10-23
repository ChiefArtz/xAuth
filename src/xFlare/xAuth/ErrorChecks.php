<?php
/*
                            _     _     
            /\             | |   | |    
 __  __    /  \     _   _  | |_  | |__  
 \ \/ /   / /\ \   | | | | | __| | '_ \ 
  >  <   / ____ \  | |_| | | |_  | | | |
 /_/\_\ /_/    \_\  \__,_|  \__| |_| |_|
                                        
                                        */
#Helps server stay alive if it is lagging.
namespace xFlare\xAuth;

use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
class ErrorChecks extends PluginTask{
    public function __construct(Loader $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->length = -1;
    }
    public function onRun($currentTick){
       if($this->owner->memorymanagerdata === 1){ //Make sure server is not lagging.
         //Check for errors.
       }
       else{
        if($this->owner->debug === true){
          $this->owner->getServer()->getLogger()->info("ErrorChecks for MySQL have been disabled until lag goes away.");
        }
      }
    }
  }

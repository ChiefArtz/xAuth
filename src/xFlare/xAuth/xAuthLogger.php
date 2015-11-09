<?php
/*
                            _     _     
            /\             | |   | |    
 __  __    /  \     _   _  | |_  | |__  
 \ \/ /   / /\ \   | | | | | __| | '_ \ 
  >  <   / ____ \  | |_| | | |_  | | | |
 /_/\_\ /_/    \_\  \__,_|  \__| |_| |_|
                                        
                                        */
namespace xFlare\xAuth;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
/*
- xAuth runs tasks here to log stuff if enabled. Useful to track bugs.
*/
class xAuthLogger implements Listener{
	public function __construct(Loader $plugin){
        $this->plugin = $plugin;
  }
  public function onWrite($exception){
    $logger = $this->plugin->getDataFolder() . "authlogs.log/";
    if($this->enabled === true ){
      $prefix = "[Critical]";
    }
    if($this->enabled === "failed"){
      $prefix = "[Failure]";
    }
    if($this->enabled === null){
      $prefix = "[PreloadError]";
    }
    file_put_contents($logger, $exception);
  }
}

<?php

#Helps users authenticate by telling them what to do on the hotbar.

namespace xFlare\xAuth;

use pocketmine\Server;
use pocketmine\scheduler\PluginTask;
class AuthMessage extends PluginTask{
    public function __construct(Loader $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
        $this->length = -1;
    }
    public function onRun($currentTick){
        if($this->owner->status === "enabled"){
            foreach($this->owner->getServer()->getOnlinePlayers() as $p){
                if($this->owner->loginmanager[$p->getId()] === 0){
                    $p->sendTip("xAuth: Please authenticate, follow the directions in chat.");
                }
            } 
        }
        elseif($this->owner->safemode === true && $this->owner->status !== "enabled"){
            foreach($this->owner->getServer()->getOnlinePlayers() as $p){
                $p->sendTip("[xAuth] xAuth is disabled, please check console!");
            }
        }
    }
}

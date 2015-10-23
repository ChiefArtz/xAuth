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
            #$p->sendTip(); Will put this wth login checks and ect.
          }
        }
        elseif($this->isOp($p) && $this->owner->status !== "enabled"){
          $p->sendTip("[xAuth] xAuth is disabled, please check console!");
        }
    }
}

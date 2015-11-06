<?php
/*
                            _     _     
            /\             | |   | |    
 __  __    /  \     _   _  | |_  | |__  
 \ \/ /   / /\ \   | | | | | __| | '_ \ 
  >  <   / ____ \  | |_| | | |_  | | | |
 /_/\_\ /_/    \_\  \__,_|  \__| |_| |_|
                                        
                                        */

#Controls logins and registers.
namespace xFlare\xAuth;

use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Server;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;

/*
- 2 = Registered. (Implementing later...)
- 1 = Logged in.
- 0 = Not logged in or registered.
*/

class LoginAndRegister implements Listener{
	public function __construct(Loader $plugin){
        $this->plugin = $plugin;
    }
    public function onJoin(PlayerJoinEvent $event){
    	if($this->plugin->status === "enabled"){
    		$event->getPlayer()->sendMessage("[xAuth] This server is protected by xAuth.");
    	}
    	if($this->plugin->status === "enabled" and $this->plugin->provider === "yml"){
            $myuser = new Config($this->plugin->getDataFolder() . "users/" . strtolower($event->getPlayer()->getName() . ".yml"), Config::YAML);
        	if(!$this->plugin->registered->exists(strtolower($event->getPlayer()->getName()))){
        		$this->plugin->proccessmanager[$event->getPlayer()->getId()] = 0;
                $this->plugin->loginmanager[$event->getPlayer()->getId()] = 0;
                $event->getPlayer()->sendMessage("[xAuth] You are not registered.");
                $event->getPlayer()->sendMessage("[xAuth] Type your wanted password in chat.");
        		return;
            }
            else{
                if($this->plugin->getConfig("ip-auth") === true && $myuser->get("myip") !== $event->getPlayer()->getAddress()){
                    $this->plugin->proccessmanager[$event->getPlayer()->getId()] = 2;
                    $event->getPlayer()->sendMessage("[xAuth] Your IP does not match.");
                    $event->getPlayer()->sendMessage("[xAuth] Please type your password in chat.");
                    return;
                }
                if($this->plugin->getConfig("ip-auth") === true && $myuser->get("myip") === $event->getPlayer()->getAddress()){
                    $event->getPlayer()->sendMessage("[xAuth] You are now logged-in.");
                    return;
                }
                if($this->plugin->getConfig("ip-auth") !== true){
                    $event->getPlayer()->sendMessage("[xAuth] Please type your password in chat to log-in.");
                    return;
                }
        	    else{
        		  $this->chatmanager[$event->getPlayer()->getId()] = 1;
        		  $event->getPlayer()->sendMessage("[xAuth] You are now logged-in.");
                }
            }
        }
    }
    public function onChat(PlayerChatEvent $event){
        if($this->plugin->status === "enabled" and $this->plugin->loginmanager[$event->getPlayer()->getId()] !== 1){
            if($this->plugin->provider === "yml"){
            	if($this->plugin->loginmanager[$event->getPlayer()->getId()] === 0){
            		$event->getPlayer()->sendMessage("Thanks! Please re-type your wanted password in chat.");
            		$this->plugin->loginmanager[$event->getPlayer()->getId()] = $message;
            		
            	}
            	elseif($this->plugin->loginmanager[$event->getPlayer()->getId()] === $message){
            		$this->proccessPassword($message, 0, $event->getPlayer());
            		$event->getPlayer()->sendMessage("You are now registered.");
            		unset($this->plugin->proccessmanager[$event->getPlayer()->getId()]);
            	}
            }
            elseif($this->owner->provider === "mysql"){
                $event->getPlayer()->sendMessage("> Connecting to MySQL server..Please wait.");
                //Manage login/register for provider.
            }
        }
        else{
        	$ecr = $this->proccessPassword($event->getMessage(), 1);
        	if($myuser->get("password") === $ecr){
        		$event->getPlayer()->sendMessage("You are now logged in.");
                $name = $event->getPlayer()->getName();
                $p->sendTip("Welcome, $name to the server!");
        	}
        	else{
        		$event->getPlayer()->sendMessage("Login failed.");
        	}
        }
    }
    public function proccessPassword($password, $type, $player){
    	if($this->simplePassword === true && $this->plugin->status === "enabled"){
    		if($password === 123456789 || $password === 987654321 || $password === "asdfg" || $password === "password"){
    			$player->sendMessage("[xAuth] That password is too simple!");
    			$player->sendMessage("[xAuth] Make it harder by adding letters and numbers!");
    			return;
    		}
    	}
    	$myuser = new Config($this->myuser . "users/" . strtolower($player->getName() . ".yml"), Config::YAML);
    	if($type === 0 && $this->plugin->status === "enabled"){
    		if(strlen($password) > 5){
    			$player->sendMessage("[xAuth] Your password was too short!");
    			return;
    		}
    		if(strlen($password) < 15){
    			$player->sendMessage("[xAuth] Your password was too long!");
    			return;
    		}
    		$myuser->set("password", md5($password));
    		$myuser->save();
    	}
    	else{
    		if($this->plugin->status === "enabled"){
    			return md5($password);
    		}
    	}
    }
}


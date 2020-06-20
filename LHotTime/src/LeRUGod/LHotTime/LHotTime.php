<?php


namespace LeRUGod\LHotTime;

use LeRUGod\LHotTime\command\HotTimeCommand;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class LHotTime extends PluginBase implements Listener
{

    public $data;
    public $db;

    public $sy = "§b§l[ §f시스템 §b]§r ";

    private static $instance;

    public function onEnable()
    {
        @mkdir($this->getDataFolder());
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->getServer()->getCommandMap()->register('HotTime',new HotTimeCommand());
        $this->data = new Config($this->getDataFolder().'hottime.yml',Config::YAML);
        $this->db = $this->data->getAll();
        if (!isset($this->db['hottime']['ing'])){

            $this->db['hottime']['ing'] = false;
            $this->db['hottime']['chat'] = false;
            $this->db['hottime']['move'] = false;
            $this->db['hottime']['drop'] = false;
            $this->db['hottime']['place'] = false;
            $this->db['hottime']['break'] = false;

        }

        if ($this->db['hottime']['ing'] == true){

            $this->db['hottime']['ing'] = false;
            $this->db['hottime']['chat'] = false;
            $this->db['hottime']['move'] = false;
            $this->db['hottime']['drop'] = false;
            $this->db['hottime']['place'] = false;
            $this->db['hottime']['break'] = false;

        }
    }

    public function onLoad()
    {
        self::$instance = $this;
    }

    public static function getInstance(){

        return self::$instance;

    }

    public function onsave(){

        $this->data->setAll($this->db);
        $this->data->save();

    }

    /*
     * 여기에 파라미터를 집어넣을때에는 jsonserialize 된걸 넣으셔야합니다!
     * 안그러면 서버 꺼집니다!
     *
     * to Developers
     */

    public function giveitem($item) : void {

        $it = Item::jsonDeserialize($item);

        foreach ($this->getServer()->getOnlinePlayers() as $player){

            if ($player->isOp()){

                continue;

            }else{

                $player->getInventory()->addItem($it);

            }

        }

    }

    public function disableChat(PlayerChatEvent $event) : void {

        if (!$event->getPlayer()->isOp() and $this->db['hottime']['chat'] == true){

            $event->setCancelled(true);
            $event->getPlayer()->sendMessage($this->sy."§l§f현재 채팅 금지 상태입니다!");

        }

    }

    public function disableMove(PlayerMoveEvent $event) : void {

        if (!$event->getPlayer()->isOp() and $this->db['hottime']['move'] == true){

            $event->setCancelled(true);
            $event->getPlayer()->sendPopup($this->sy."§l§f현재 움직임 금지 상태입니다!");

        }

    }

    public function disableDrop(PlayerDropItemEvent $event) : void {

        if (!$event->getPlayer()->isOp() and $this->db['hottime']['drop'] == true){

            $event->setCancelled(true);
            $event->getPlayer()->sendPopup($this->sy."§l§f현재 드롭 금지 상태입니다!");

        }

    }

    public function disablePlace(BlockPlaceEvent $event) : void {

        if (!$event->getPlayer()->isOp() and $this->db['hottime']['place'] == true){

            $event->setCancelled(true);
            $event->getPlayer()->sendPopup($this->sy."§l§f현재 블록 설치 금지 상태입니다!");

        }

    }

    public function disableBreak(BlockBreakEvent $event) : void {

        if (!$event->getPlayer()->isOp() and $this->db['hottime']['break'] == true){

            $event->setCancelled(true);
            $event->getPlayer()->sendPopup($this->sy."§l§f현재 블록 파괴 금지 상태입니다!");

        }

    }
}
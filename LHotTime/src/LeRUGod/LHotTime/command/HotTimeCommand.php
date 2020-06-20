<?php

namespace LeRUGod\LHotTime\command;


use LeRUGod\LHotTime\LHotTime;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class HotTimeCommand extends Command
{

    public $sy = "§b§l[ §f시스템 §b]§r ";

    public function __construct()
    {
        parent::__construct('핫타임','핫타임 커맨드입니다!','/핫타임',['hottime']);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player)return;
        if (isset($args[0])){

            switch ($args[0]){

                case '시작':
                    if (!$sender->isOp()){
                        $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                        return;
                    }elseif (!LHotTime::getInstance()->db['hottime']['ing'] == false){
                        $sender->sendMessage($this->sy."§l§f이미 핫타임이 진행중입니다!");
                        return;
                    }else{
                        LHotTime::getInstance()->db['hottime']['ing'] = true;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 핫타임을 시작하셨습니다!");
                    }
                    break;
                case '지급':
                    if (!$sender->isOp()){
                        $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                        return;
                    }elseif (LHotTime::getInstance()->db['hottime']['ing'] == false){
                        $sender->sendMessage($this->sy."§l§f핫타임 시작 후에 이용해주세요!");
                        return;
                    }else{
                        $item = $sender->getInventory()->getItemInHand();
                        if ($item->getId() == 0){
                            $sender->sendMessage($this->sy."§l§f지급할 아이템을 들고 명령어를 실행해주세요!");
                            return;
                        }
                        $it = $item->jsonSerialize();
                        if ($item->getCustomName() == null){
                            $name = $item->getName();
                        }else{
                            $name = $item->getCustomName();
                        }
                        LHotTime::getInstance()->giveitem($it);
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 전체에게 ".$name." §f아이템을 ".$item->getCount()." 개 만큼 지급하였습니다!");
                    }
                    break;
                case '채팅':
                    if (!$sender->isOp()){
                        $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                        return;
                    }elseif (!LHotTime::getInstance()->db['hottime']['ing'] == true){
                        $sender->sendMessage($this->sy."§l§f핫타임 시작 후에 이용해주세요!");
                        return;
                    }elseif (LHotTime::getInstance()->db['hottime']['chat'] == true){
                        LHotTime::getInstance()->db['hottime']['chat'] = false;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 채팅 금지를 해제하였습니다!");
                    }else{
                        LHotTime::getInstance()->db['hottime']['chat'] = true;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 채팅을 금지하였습니다!");
                    }
                    break;
                case '움직임':
                    if (!$sender->isOp()){
                        $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                        return;
                    }elseif (!LHotTime::getInstance()->db['hottime']['ing'] == true){
                        $sender->sendMessage($this->sy."§l§f핫타임 시작 후에 이용해주세요!");
                        return;
                    }elseif (LHotTime::getInstance()->db['hottime']['move'] == true){
                        LHotTime::getInstance()->db['hottime']['move'] = false;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 움직임 금지를 해제하였습니다!");
                    }else{
                        LHotTime::getInstance()->db['hottime']['move'] = true;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 움직임을 금지하였습니다!");
                    }
                    break;
                case '드롭':
                    if (!$sender->isOp()){
                        $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                        return;
                    }elseif (!LHotTime::getInstance()->db['hottime']['ing'] == true){
                        $sender->sendMessage($this->sy."§l§f핫타임 시작 후에 이용해주세요!");
                        return;
                    }elseif (LHotTime::getInstance()->db['hottime']['drop'] == true){
                        LHotTime::getInstance()->db['hottime']['drop'] = false;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 드롭 금지를 해제하였습니다!");
                    }else{
                        LHotTime::getInstance()->db['hottime']['drop'] = true;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 드롭을 금지하였습니다!");
                    }
                    break;
                case '블록설치':
                    if (!$sender->isOp()){
                        $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                        return;
                    }elseif (!LHotTime::getInstance()->db['hottime']['ing'] == true){
                        $sender->sendMessage($this->sy."§l§f핫타임 시작 후에 이용해주세요!");
                        return;
                    }elseif (LHotTime::getInstance()->db['hottime']['place'] == true){
                        LHotTime::getInstance()->db['hottime']['place'] = false;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 블록 설치 금지를 해제하였습니다!");
                    }else{
                        LHotTime::getInstance()->db['hottime']['place'] = true;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 블록 설치를 금지하였습니다!");
                    }
                    break;
                case '블록파괴':
                    if (!$sender->isOp()){
                        $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                        return;
                    }elseif (!LHotTime::getInstance()->db['hottime']['ing'] == true){
                        $sender->sendMessage($this->sy."§l§f핫타임 시작 후에 이용해주세요!");
                        return;
                    }elseif (LHotTime::getInstance()->db['hottime']['break'] == true){
                        LHotTime::getInstance()->db['hottime']['break'] = false;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 블록 파괴 금지를 해제하였습니다!");
                    }else{
                        LHotTime::getInstance()->db['hottime']['break'] = true;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 블록 파괴를 금지하였습니다!");
                    }
                    break;
                case '종료':
                    if (!$sender->isOp()){
                        $sender->sendMessage($this->sy."§l§fOP만 사용가능한 명령어입니다!");
                        return;
                    }elseif (!LHotTime::getInstance()->db['hottime']['ing'] == true){
                        $sender->sendMessage($this->sy."§l§f핫타임이 진행중이 아닙니다!");
                        return;
                    }else{
                        LHotTime::getInstance()->db['hottime']['ing'] = false;
                        LHotTime::getInstance()->db['hottime']['chat'] = false;
                        LHotTime::getInstance()->db['hottime']['move'] = false;
                        LHotTime::getInstance()->db['hottime']['drop'] = false;
                        LHotTime::getInstance()->db['hottime']['place'] = false;
                        LHotTime::getInstance()->db['hottime']['break'] = false;
                        LHotTime::getInstance()->onsave();
                        LHotTime::getInstance()->getServer()->broadcastMessage($this->sy."§l§f".$sender->getName()." 님이 핫타임을 종료하셨습니다!");
                    }
                    break;
                default:
                    if (!$sender->isOp()){
                        $sender->sendMessage($this->sy . "§l§fOP만 사용가능한 명령어입니다!");
                        return;
                    }else{
                        $sender->sendMessage($this->sy . "§l§f/핫타임 [ 시작 | 종료 | 채팅 | 드롭 | 움직임 | 블록설치 | 블록파괴 ]");
                        return;
                    }
            }
        }else{
            if (!$sender->isOp()){
                $sender->sendMessage($this->sy . "§l§fOP만 사용가능한 명령어입니다!");
                return;
            }else{
                $sender->sendMessage($this->sy . "§l§f/핫타임 [ 시작 | 종료 | 채팅 | 드롭 | 움직임 | 블록설치 | 블록파괴 ]");
                return;
            }
        }
    }

}
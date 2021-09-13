<?php
/**
███╗░░██╗░██████╗░██╗░░░██╗██╗░░░██╗███████╗███╗░░██╗██████╗░██╗░░░██╗░█████╗░██╗░░██╗
████╗░██║██╔════╝░██║░░░██║╚██╗░██╔╝██╔════╝████╗░██║██╔══██╗██║░░░██║██╔══██╗██║░██╔╝
██╔██╗██║██║░░██╗░██║░░░██║░╚████╔╝░█████╗░░██╔██╗██║██║░░██║██║░░░██║██║░░╚═╝█████═╝░
██║╚████║██║░░╚██╗██║░░░██║░░╚██╔╝░░██╔══╝░░██║╚████║██║░░██║██║░░░██║██║░░██╗██╔═██╗░
██║░╚███║╚██████╔╝╚██████╔╝░░░██║░░░███████╗██║░╚███║██████╔╝╚██████╔╝╚█████╔╝██║░╚██╗
╚═╝░░╚══╝░╚═════╝░░╚═════╝░░░░╚═╝░░░╚══════╝╚═╝░░╚══╝╚═════╝░░╚═════╝░░╚════╝░╚═╝░░╚═╝
 */
declare(strict_types=1);

namespace NguyenDuck\PluginUI;

use pocketmine\Server;
use pocketmine\utils\TextFormat;
use jojoe77777\FormAPI\Form;
use function count;
use function implode;
use function array_push;

class PluginInfoForm extends Form
{
    public function __construct(?callable $callable = null, string $pluginName) {
        parent::__construct($callable);
        $plugin = Server::getInstance()->getPluginManager()->getPlugin($pluginName)->getDescription();
        $authors = (count($plugin->getAuthors())>1?"\n":"").implode(", ", $plugin->getAuthors());
        $commands = "";
        foreach ($plugin->getCommands() as $value) {
            $text = [];
            foreach ($value as $t) {
                array_push($text, $t);
            }
            $commands = $commands."\n".$text[1]." - ".$text[0];
        }
        $content = $plugin->getFullName()." by ".$authors."\n".$plugin->getDescription()."\n".$commands;
        $this->data["type"] = "form";
        $this->data["title"] = $plugin->getName();
        $this->data["content"] = $content;
        $this->data["buttons"][] = ["text" => "Exit"];
    }
}
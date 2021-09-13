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

class PluginInfoForm extends Form
{
    public function __construct(?callable $callable = null, string $pluginName) {
        parent::__construct($callable);
        $plugin = Server::getInstance()->getPluginManager()->getPlugin($pluginName)->getDescription();
        $content = $plugin->getFullName() . " by " . (count($plugin->getAuthors()) > 1 ? "\n" : "") . implode(", " ,$plugin->getAuthors()) . "\n" . $plugin->getDescription();
        $this->data["type"] = "form";
        $this->data["title"] = $plugin->getName();
        $this->data["content"] = $content;
        $this->data["buttons"][] = ["text" => "Exit"];
    }
}
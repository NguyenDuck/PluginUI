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

        $plugins = Server::getInstance()->getPluginManager()->getPlugin($pluginName);
        $plugin = $plugins->getDescription();
        
        $authors = (count($plugin->getAuthors())>1?"\n":"").implode(", ", $plugin->getAuthors());
        $authorsText = ($authors?" bởi ".$authors:"");
        $pluginEnabledText = "Tình Trạng: ".($plugins->isEnabled()?"Đã":"Chưa")." Kích Hoạt";

        $content = [
            $plugin->getFullName().$authorsText,
            $pluginEnabledText,
            $plugin->getDescription()
        ];

        $this->data["type"] = "form";
        $this->data["title"] = $plugin->getName();
        $this->data["content"] = implode("\n", $content);
        $this->data["buttons"][] = ["text" => "Thoát"];
    }
}
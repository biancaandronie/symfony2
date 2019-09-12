<?php

/**
 * Created by PhpStorm.
 * User: Bianca
 * Date: 9/11/2019
 * Time: 3:36 PM
 */
namespace App\Service;


use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelp
{

    private $markdown;
    private $cache;
    private $logger;
    private $isDebug;

    public function __construct(MarkdownInterface $markdown, AdapterInterface $cache, LoggerInterface $markdown_logger, bool $isDebug)
    {

        $this->markdown = $markdown;
        $this->cache = $cache;
        $this->logger = $markdown_logger;
        $this->isDebug = $isDebug;
    }

    public function parse(string $art):string {

        if(stripos($art, 'shank') !==false ){
            $this->logger->info('shank');
        }

        if($this->isDebug){
            return $this->markdown->transform($art);
        }

        $item = $this->cache->getItem('marks'.md5($art));
        if(!$item->isHit()){
            $item->set($this->markdown->transform($art));
            $this->cache->save($item);
        }
        return $item->get();
    }

}
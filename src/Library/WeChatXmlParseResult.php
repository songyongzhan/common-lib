<?php

namespace Songyz\Common\Library;

/**
 *
 * Class WeChatXmlParseResult
 * @url https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Receiving_standard_messages.html
 * @package Songyz\Common\Library
 * @date 2022/4/15 18:41
 */
class WeChatXmlParseResult
{

    private $toUserName;
    private $fromUserName;
    private $createTime;
    private $msgType;
    private $event;
    private $eventKey;
    private $msgId;
    private $content;



    /**
     * 私有构造方法
     * WeChatXmlParseResult constructor.
     */
    private function __construct()
    {
    }

    /**
     * 解析微信收到的xml
     * loadXml
     * @param string $xml
     * @return WeChatXmlParseResult
     *
     * @date 2022/4/15 17:22
     */
    public static function loadXml(string $xml): WeChatXmlParseResult
    {
        $res = new WeChatXmlParseResult();
        if (!empty($xml)) {
            $xmlResult = simplexml_load_string($xml);

            $data = (array)$xmlResult;
            foreach ($data as $key => $v) {
                $res->{lcfirst($key)} = strval($v);
            }
        }

        return $res;
    }

    /**
     * @return mixed
     */
    public function getToUserName()
    {
        return $this->toUserName;
    }

    /**
     * @return mixed
     */
    public function getFromUserName()
    {
        return $this->fromUserName;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @return mixed
     */
    public function getMsgType()
    {
        return $this->msgType;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return mixed
     */
    public function getEventKey()
    {
        return $this->eventKey;
    }

    /**
     * @return mixed
     */
    public function getMsgId()
    {
        return $this->msgId;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

}

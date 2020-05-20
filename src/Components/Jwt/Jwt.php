<?php

namespace Songyz\Common\Components\Jwt;

use Lcobucci\JWT\Builder;

class Jwt extends Builder
{
    /**
     * 设置不同的值
     * withClaim
     * @param $name
     * @param string $value
     * @return $this
     * @author songyz <574482856@qq.com>
     * @date 2020/1/10 18:22
     */
    public function withClaim($name, $value = '')
    {
        if (is_array($name) && !empty($name)) {
            foreach ($name as $k => $v) {
                parent::withClaim($k, $v);
            }
        } elseif (!empty($name)) {
            parent::withClaim($name, $value);
        }

        return $this;
    }

}

<?php


namespace rpc\Service;


class CartService
{
    public function getList($page)
    {
        return [
            [
                'name' => 'zhangsan',
                'sex' => $page,
            ],
            [
                'name' => 'lisi',
                'sex' => 0,
            ]
        ];
    }
}
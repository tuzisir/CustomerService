<?php
/**
 * User: 郭玉朝
 * CreateTime: 2018/4/27 下午4:16
 * Description:
 */
namespace App\Common\Model\ModelInter;
interface ModelBaseInter
{
    public static function instance();

    public function addInfo(array $data):bool;

    public function editInfo(array $condition, array $data);

    public function delInfo(array $condition);

    public function selectInfo(array $condition);

    public function findInfo(array $condition);
}
<?php
/**
 * User: 郭玉朝
 * CreateTime: 2018/4/27 下午11:48
 * Description:
 */
namespace App\Api\ApiInter;
use Tool\Request\Request;

interface CustomerServiceApiInter
{

    public function addCustomerService();

    public function editCustomerService();

    public function delCustomerService();

    public function findCustomerService();

    public function isOnlineCustomerService();

}
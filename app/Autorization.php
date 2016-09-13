<?php
namespace app;
class Autorization
{
    private $gateAway = NULL;
    
    public function __construct(AbiturientDataGateway $gateAway)
    {
        $this->gateAway = $gateAway;
    }    
    // Генерация нового пароля
    public function generatePass()
    {
        $pass = md5(uniqid(rand(),true));
        return $pass;
    }
    
    // Проверка регистрации
    public function isRegistered($userPassword)
    {
        return $this->getUserId($userPassword);
    }
    // Возвращает id по паролю
    public function getUserId($userPassword)
    {
        return $this->gateAway->getIdByPassword($userPassword);
    }
   
}

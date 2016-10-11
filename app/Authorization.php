<?php
namespace app;
class Authorization
{
    private $gateAway = NULL;
    private $userId = NULL;
    private $userPass = NULL;

    public function __construct(AbiturientDataGateway $gateAway)
    {
        $this->gateAway = $gateAway;
    } 
   
    // Возвращает id по паролю
    public function getUserId()
    {
        $pass = $this->getPass();        
        
        if ($this->userId) {
            return $this->userId;
        } else if ($pass) {
            $passHash = $this->hashPass($pass);
            $this->userId = $this->gateAway->getIdByPassHash($passHash);
        }
        return $this->userId;
    }
    // Авторизация
    public function authorize()
    {
        $pass = $this->getPass();
        if ($pass) {
            $userId = $this->getUserId();    
        }        
        if ($pass && $userId) {
            return TRUE;
        } else {
            return FALSE;
        }        
    }
    // Регистрация
    public function createNewRegistry()
    {
        $pass = $this->generatePass();
        $this->userPass = $pass;
        $this->setCoockiePass($pass);
        $passHash = $this->hashPass($pass);        
        return $passHash;
    }
    
    // Считывание кук
    private function getPass()
    {
        if ($this->userPass) {
            return $this->userPass;
        } else {
            if (isset($_COOKIE['userPassword'])) {
                return $_COOKIE['userPassword'];
            }
        }        
        return FALSE;
    }
    // Установка кук
    private function setCoockiePass($pass)
    {
        setcookie ('userPassword', $pass, strtotime( '+10 years' ));  
    }
    // Генерация нового пароля
    private function generatePass()
    {
        $pass = "";
        for($i = 0; $i < 16; $i++) {
            $pass .= chr(mt_rand (0, 255));
        }        
        return $pass;
    } 
    // Хеширование пароля
    private function hashPass($pass)
    {
        return md5($pass);
    }    
}

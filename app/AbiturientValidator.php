<?php
namespace app;
class AbiturientValidator
{   
    public function findForbidden($regExp, $value)
    {
        $value = mb_check_encoding($value, 'UTF-8') ? $value : utf8_encode($value);
        preg_match_all($regExp, $value, $forbiddenSymbols, PREG_PATTERN_ORDER);
        if (!empty($forbiddenSymbols[0])) {
            $forbiddenSymbols = '"' . implode('", "',$forbiddenSymbols[0]) . '"';
            return $forbiddenSymbols;
        }
        return FALSE;
    }
    public function validateEmail($value)    {       
        preg_match('!\\w+@\\w+\\.\\w+!u', $value, $match);
        if (!isset($match[0])) {
            return $value;
        }
        return FALSE;
    }    
    public function validateLenght($value, $maxLength, $minLength = 0)
    {
        if (mb_strlen($value)>$maxLength | mb_strlen($value)<$minLength) {
            return mb_strlen($value);
        }  
        return FALSE;
    }
    public function validateIntForMaxMin($value, $max, $min = 0)
    {
        if ($value>$max || $value<$min) {
            return $value;
        }  
        return FALSE;
    }
    public function validateBoolean($value)
    {
        if ($value != 0 && $value != 1) {
            return $value;
        }  
        return FALSE;
    } 
    public function validate(Abiturient $abiturient)
    {        
        $errors = new Errors;
       
        // Имя
        $name = $abiturient->name;
        $errors->add('nameForbidden', $this->findForbidden('/[^a-zа-яё]/ui', $name));
        $errors->add('nameLength', $this->validateLenght($name, 90));

        // Фамилия 
        $lastName = $abiturient->lastName;
        $errors->add('lastNameForbidden', $this->findForbidden('/[^a-zа-яё\\-\\`]/ui', $lastName));
        $errors->add('lastNameLength', $this->validateLenght($lastName, 90));

        // Пол
        $gender = $abiturient->gender;
        $errors->add('gender', $this->validateBoolean($gender));
        
        // Номер группы
        $groupNum = $abiturient->groupNum;
        $errors->add('groupNumForbidden', $this->findForbidden('/[^a-zа-яё0-9\\-]/ui', $groupNum));
        $errors->add('groupNumLength', $this->validateLenght($groupNum, 10, 2)); // строка, макс длина, мин длина
        
        // Email
        $email = $abiturient->email;
        $errors->add('email', $this->validateEmail($email));        

        // Суммарное количество баллов ЕГЭ
        $egePoints = $abiturient->egePoints;
        $errors->add('egePointsForbidden', $this->findForbidden('/[^0-9]/u', $egePoints));
        $errors->add('egePointsMaxMin', $this->validateIntForMaxMin($egePoints, 400, 0)); 
        
        // Год рождения
        $dateOfBirth = $abiturient->dateOfBirth;
        $errors->add('dateOfBirthForbidden', $this->findForbidden('/[^0-9]/u', $dateOfBirth));
        $errors->add('dateOfBirthMaxMin', $this->validateIntForMaxMin($dateOfBirth, date("Y"), 1900));
        
        // Прописка (местная)
        $registry = $abiturient->registry;
        $errors->add('registry', $this->validateBoolean($registry));
        
        
        return $errors;
    }  
}


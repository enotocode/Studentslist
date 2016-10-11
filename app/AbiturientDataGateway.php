<?php
namespace app;

class AbiturientDataGateway
{
    // Константы
    const ASC = 'ASC';
    const DESC = 'DESC';
    
    private $pdo = null;
    private $sort = array(
                        "name"          =>  "name",
                        "lastName"      =>  "lastName",
                        "gender"        =>  "gender",
                        "groupNum"      =>  "groupNum",
                        "email"         =>  "email",
                        "egePoints"     =>  "egePoints",
                        "dateOfBirth"   =>  "dateOfBirth",    
                        "registry"      =>  "registry",
                        "userPassHash"  =>  "userPassHash"
                         );    
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;        
    }
    public function addAbiturient(Abiturient $abiturient)
    {
        $allowed = array(
                            'name',
                            'lastName',
                            'gender',
                            'groupNum',
                            'email',
                            'egePoints',
                            'dateOfBirth',    
                            'registry',
                            'userPassHash'
                        );
        $values = $this->getAbiturientAsArray($abiturient, $allowed);
        $sql = "INSERT INTO abiturients SET " . $this->pdoSet($allowed, $values);
        $stm = $this->pdo->prepare($sql);
        $stm->execute($values);
    }
    public function getAbiturient($id)
    {
        $sql = "SELECT * FROM abiturients WHERE id = ?";
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(1, $id, \PDO::PARAM_STR);
        $stm->execute();
        $abiturient = $this->createAbiturient($stm->fetch(\PDO::FETCH_ASSOC));        

        return $abiturient;
    }
    public function updateAbiturient(Abiturient $abiturient, $id)
    {        
        $allowed = array(
                            'name',
                            'lastName',
                            'gender',
                            'groupNum',
                            'email',
                            'egePoints',
                            'dateOfBirth',    
                            'registry'
                        );
        $values = $this->getAbiturientAsArray($abiturient, $allowed);
        $sql = "UPDATE abiturients SET " . $this->pdoSet($allowed, $values) . " WHERE id = :id";
        $values['id'] = $id;
        $stm = $this->pdo->prepare($sql);
        $stm->execute($values);               
    }
    public function getAbiturients($searchKey, $limit, $offset, $colum, $order)
    {       
        $sql = "SELECT name, lastName, groupNum, egePoints
                FROM abiturients";
        $searchKey = $this->filterSymbols($searchKey);
        if ($searchKey!=" " && $searchKey!="") {
            $sql .= " WHERE CONCAT (name, lastName, groupNum, egePoints, email, dateOfBirth) LIKE '%" . $searchKey . "%'";
        } 
        if (isset($colum)) {            
            $sql .= " ORDER BY " . $this->sort[$colum];
        }  else {
            $sql .= " ORDER BY egePoints";
        }
        if (isset($order) && $order==self::DESC && (isset($colum))) {            
            $sql .= " DESC";
        } else if (isset($order) && $order==self::DESC && (!isset($colum))) {
            $sql .= " ORDER BY name DESC";
        }
        if (isset($limit) && isset($offset)) {            
            $sql .= " LIMIT " . $offset . ", " . $limit;
        }
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        $values = $stm->fetchAll(\PDO::FETCH_ASSOC);
        $abiturients = $this->createAbiturient($values);
        return $abiturients;
    }                
    public function countSearchingAbiturients($searchKey)
    {       
        $searchKey = $this->filterSymbols($searchKey);
        $sql = "SELECT COUNT(*)
                FROM abiturients
                WHERE CONCAT(name, lastName, groupNum, egePoints, email)
                LIKE '%" . $searchKey ."%'";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchColumn();
        return $result;
    }
    public function getIdByPassHash($userPassHash)
    {
        //$sql = "SELECT id FROM abiturients WHERE userpassword = ?"// . $userPassHash;        
        $stm = $this->pdo->prepare("SELECT id FROM abiturients WHERE userPassHash = ?");
        $stm->bindValue(1, $userPassHash, \PDO::PARAM_STR);
        $stm->execute();
        $id = $stm->fetchColumn();
        return $id;
    }
    public function getTotalRecords()
    {
        $stm = $this->pdo->prepare('SELECT COUNT(*) FROM abiturients');
        $stm->execute();
        $result = $stm->fetchColumn(); 
        return $result;
    }
    private function pdoSet($allowed, &$values)
    {
        $resultValues = array();
        $set = "";
        foreach($allowed as $field){
            if (isset($values[$field])){
                $resultValues[$field] = $values[$field];
                $set .= $field . "=:$field, ";
            }
        }
        $values = $resultValues;
        return substr($set, 0, -2); 
    }
    private function filterSymbols($str)
    {
        $str = preg_replace (
                                array("![^a-zA-ZА-Яа-яЁё0-9\\s]!ui", "! +!ui"),
                                array("", " "),
                                $str
                                );
        return $str;
    }
    private function getAbiturientAsArray(Abiturient $abiturient, $allowed)
    {
        foreach($allowed as $field) {
            $values[$field] = $abiturient->$field;
        }
        return $values;
    }
    private function createAbiturient(Array $values)
    {
        if (!is_array(current($values))) {
            $abiturient = new Abiturient();
            $abiturient->updateValues($values);
            return $abiturient;
        } else {
            foreach($values as $fields) {
                $abiturient = new Abiturient();
                $abiturient->updateValues($fields);
                $abiturients[] = $abiturient;
            }
        }
        return $abiturients;
    }
    
}
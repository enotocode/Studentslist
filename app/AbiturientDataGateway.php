<?php
namespace app;

class AbiturientDataGateway
{
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
                        "userPassword"  =>  "userPassword"
                         );
    
    public function __construct($pdo)
    {

        $this->pdo = $pdo;        
    }
    public function addStudent(Abiturient $abiturient)
    {
        $stm = $this->pdo->prepare("INSERT INTO abiturients (
                                name,
                                lastName,
                                gender,
                                groupNum,
                                email,
                                egePoints,
                                dateOfBirth,    
                                registry,
                                userPassword
                             )
                             values (
                                :name,
                                :lastName,
                                :gender, 
                                :groupNum,
                                :email,
                                :egePoints,
                                :dateOfBirth,
                                :registry,
                                :userPassword
                                )");        
        $values = $this->getValuesAsArray($abiturient);
        $stm->execute($values);
    }
    public function getStudent($id)
    {
        $sql = "SELECT * FROM abiturients WHERE id = " . $id;
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        $student = $stm->fetchAll(\PDO::FETCH_ASSOC);

        return $student[0];
    }
    public function updateStudent(Abiturient $abiturient, $id)
    {
        $values = $this->getValuesArray($abiturient);
        array_pop($values); // delete userPassword        
        foreach ($values as $valueName => $value) {
            $sql = "UPDATE abiturients SET " . $valueName . " = '" . $value . "' WHERE id = " . $id;
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
        }        
    }
    public function getStudents($searchKey, $limit, $offset, $colum, $order)
    {       
        $sql = "SELECT name, lastName, groupNum, egePoints
                FROM abiturients";
        $searchKey = preg_replace (
                                array("![^a-zA-ZА-Яа-я0-9\\s]!ui", "! +!ui"),
                                array("", " "),
                                $searchKey
                                );
        if ($searchKey!=" " && $searchKey!="") {
            $sql .= " WHERE CONCAT (name, lastName, groupNum, egePoints, email, dateOfBirth) LIKE '%" . $searchKey . "%'";
        } 
        if (isset($colum)) {            
            $sql .= " ORDER BY " . $this->sort[$colum];
        }  else {
            $sql .= " ORDER BY egePoints";
        }
        if (isset($order) && $order==DESC && (isset($colum))) {            
            $sql .= " DESC";
        } else if (isset($order) && $order==DESC && (!isset($colum))) {
            $sql .= " ORDER BY name DESC";
        }
        if (isset($limit) && isset($offset)) {            
            $sql .= " LIMIT " . $offset . ", " . $limit;
        }
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        $students = $stm->fetchAll(\PDO::FETCH_ASSOC);
        return $students;
    }                
    public function countSearchingStudents($searchKey)
    {       
        $searchKey = preg_replace (
                                array("![^a-zA-ZА-Яа-я0-9\s]!ui", "! +!ui"),
                                array("", " "),
                                $searchKey
                                );
        $sql = "SELECT COUNT(*)
                FROM abiturients
                WHERE CONCAT(name, lastName, groupNum, egePoints, email)
                LIKE '%" . $searchKey ."%'";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetch(\PDO::FETCH_NUM);
        return $result[0];
    }
    public function getIdByPassword($userPassword)
    {
        //$sql = "SELECT id FROM abiturients WHERE userpassword = ?"// . $userPassword;        
        $stm = $this->pdo->prepare("SELECT id FROM abiturients WHERE userpassword = ?");
        $stm->bindValue(1, $userPassword, \PDO::PARAM_STR);
        $stm->execute();
        $id = $stm->fetch(\PDO::FETCH_ASSOC);
        return $id['id'];
    }
    public function getTotalRecords()
    {
        $stm = $this->pdo->prepare('SELECT COUNT(*) FROM abiturients');
        $stm->execute();
        $result = $stm->fetch(\PDO::FETCH_NUM);
        return $result[0];
    }
    private function getValuesAsArray(Abiturient $abiturient)
    {
        $values = array (
            "name"=>$abiturient->getName(),
            "lastName"=>$abiturient->getLastName(),
            "gender"=>$abiturient->getGender(), 
            "groupNum"=>$abiturient->getGroupNum(),
            "email"=>$abiturient->getEmail(),
            "egePoints"=>$abiturient->getEgePoints(),
            "dateOfBirth"=>$abiturient->getDateOfBirth(),
            "registry"=>$abiturient->getRegistry(),
            "userPassword"=>$abiturient->getUserPassword()
        );
        return $values;
    }
}
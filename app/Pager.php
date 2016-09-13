<?php
namespace app;
class Pager
{
    private $totalRecords;
    private $recordsPerPage;
    
    public function __construct($totalRecords, $recordsPerPage)
    {
        $this->totalRecords = $totalRecords;
        $this->recordsPerPage = $recordsPerPage;
    }
    public function getTotalPages()
    {
        if ($this->totalRecords < $this->recordsPerPage) {
            return 1;
        } else {
            $totalPages = ceil($this->totalRecords / $this->recordsPerPage);
            return $totalPages;
        }        
    }
    public function getOffset($pageNum)
    {
        if ($pageNum == 1 | !isset($pageNum)) {
            return 0;
        } else {
            return $this->recordsPerPage * $pageNum - $this->recordsPerPage;
        }        
    }
    public function getLimit($pageNum)
    {
        return $this->recordsPerPage;               
    }
}

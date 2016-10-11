<?php
namespace app;
class LinkHelper
{
    // сортировка
    public static function getSortingLink(Array $curl, $column)
    {
        // Меняем направление сортировки при повтроном клике на колонку сортировки
        if (isset($curl['sort']) && $curl['sort']==$column) {
            $curl['order'] = LinkHelper::getOrder($curl['order']);
        } else {
            $curl['sort'] = $column;
        }      

        $link = "index.php" . "?" . http_build_query($curl);
        return $link;
    }
    public static function getLink(Array $curl)
    {
        // index.php?search=cat&sort=name&page=2&order=ASC
        $link = $page . "?" . http_build_query($curl);
        return $link;
    }
    public static function getPageLink($pageNum, Array $curl)
    {
        $curl['page'] = $pageNum;
        $link = 'index.php' . "?" . http_build_query($curl);        
        return $link;
    }
    public static function getFirstPageLink()
    {
        $link = 'index.php' . "?" . http_build_query(['page'=>1]);        
        return $link;
    }
    public static function getRegisterLink()
    {
        $link = 'register.php';        
        return $link;
    }
    private static function getOrder($order)
    {
        if (!isset($order) | $order == AbiturientDataGateway::ASC) {
            return AbiturientDataGateway::DESC;
        } else {
            return AbiturientDataGateway::ASC;
        }        
    }
    
    public static function getOrderIcon(Array $curl, $colum)
    {
        if ($curl['sort'] == $colum) {
            if (!isset($curl['order']) | $curl['order'] == AbiturientDataGateway::ASC) {
                return "&#9650";
            } else if (isset($curl['order']) | $curl['order'] == AbiturientDataGateway::DESC){
                return "&#9660";
            }
        }        
    }    
    // Валидация ссылки от клиента, фильтрует все кроме цифр
    private static function validateInt($link)
    {
        return filter_var($link, FILTER_VALIDATE_INT);
    }
}
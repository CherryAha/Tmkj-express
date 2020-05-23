<?php  
namespace zjtmkj; 
include "KdApiSearchDemo.php";
class express
{ 
    /*
     *@parmas 快递代码
     *@params 快递单号
     */
	public static function get($express_code , $express_no)
	{
		return getOrderTracesByJson($express_code,$express_no);
	} 
}  
?>

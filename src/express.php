<?php  
namespace zjtmkj; 
include "KdApiSearchDemo.php";
class express
{ 
	public static function get($express_code , $express_no)
	{
		return getOrderTracesByJson($express_code,$express_no);
	} 
}  
?>

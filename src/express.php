<?php  
namespace ZJTmkj; 
include "KdApiSearchDemo.php";
class express
{ 
	public function get($express_code , $express_no)
	{
		return getOrderTracesByJson($express_code,$express_no);
	} 
}  
?>

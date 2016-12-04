<?php
namespace app\modules\admin\tools;


class HelperTools
{
    /*
	 * 导出格式转换
	 * @author ruiqiang
	 * $head 字段 $alias 在excel表中想现实的第一行标题
	 *
	 *
	 */
    public static function arrayToString($result,$head,$alias){
        if(empty($result)){
            return false;
        }
        $data = '';
        foreach($head as $ke=>$va){
            $data .= $alias[$va].",";
        }
        $data .= "\n";
        foreach($result as $i=>$value)
        {
            for($j=0;$j<count($head);$j++)
            {
                if(isset($result[$i][$head[$j]])) $data .= $result[$i][$head[$j]].",";
                else $data .= " ,";
            }
            $data .= "\n";
        }
        return $data;
    }
}
<?php
/**
 * 排序算法
 * 
 * 冒泡排序
 * 选择排序
 * 插入排序
 * 快速排序
 */

/**
 * @param 冒泡排序
 * 它重复地走访过要排序的数列，一次比较两个元素，如果他们的顺序错误就把他们交换过来。
 * 走访数列的工作是重复地进行直到没有再需要交换，也就是说该数列已经排序完成。
 * @param [array] $arr [待排序数组]
 */
function BubbleSort($arr){
	$len = count($arr);

	//该层循环控制 需要冒泡的轮数
	for($i = 1; $i < $len; $i++){
		//本趟排序开始前，交换标志应为假
		$flag = false;

		//该层循环用来控制每轮 冒出一个数 需要比较的次数
		for($k = 0; $k < $len - $i; $k++){
			//从小到大排序
			if($arr[$k] > $arr[$k + 1]){
				$tmp = $arr[$k + 1];
				$arr[$k + 1] = $arr[$k];
				$arr[$k] = $tmp;
				$flag = true;	
			}
		}

		if(!$flag) return $arr;
	}
}

/**
 * @param 选择排序法
 * 每一次从待排序的数据元素中选出最小（或最大）的一个元素，存放在序列的起始位置，直到全部待排序的数据元素排完。
 * 选择排序是不稳定的排序方法（比如序列[5， 5， 3]第一次就将第一个[5]与[3]交换，导致第一个5挪动到第二个5后面）
 * @param [array] $arr [待排序数组]
 */
function SelectSort($arr){
	$len = count($arr);

	for($i = 0; $i < $len - 1; $i++){
		//假设$i就是最小值
		$min = $arr[$i];
		$index = $i;

		for($k = $i + 1; $k < $len; $k++){
			//从小到大排序
			if($min > $arr[$k]){
				//找最小值
				$min = $arr[$k];
				$index = $k;
			}
		}

		$temp = $arr[$i];
		$arr[$i] = $min;
		$arr[$index] = $temp;
	}
}

/**
 * 插入排序法
 * 每步将一个待排序的纪录，按其关键码值的大小插入前面已经排序的文件中适当位置上，直到全部插入完为止。
 * 算法适用于少量数据的排序，时间复杂度为O(n^2)。是稳定的排序方法。
 * @param [array] $arr [待排序数组]
 */
function InsertSort($arr){
	$len = count($arr);

	for($i = 1; $i < $len; $i++){
		//待插入数据
		$insert = $arr[$i];
		//待比较下标
		$index = $i - 1;

        while($index >= 0 && $insert < $arr[$index]){
        	//将数组往后挪
            $arr[$index + 1] = $arr[$index];
            //将下标往前挪，准备与前一个进行比较 
            $index--; 
        }
        if($index + 1 !== $i){
            $arr[$index + 1] = $insert;
        }		
	}
}

/**
 * 快速排序法
 * 通过一趟排序将要排序的数据分割成独立的两部分，其中一部分的所有数据都比另外一部分的所有数据都要小，
 * 然后再按此方法对这两部分数据分别进行快速排序，整个排序过程可以递归进行，以此达到整个数据变成有序序列。
 * @param [array] $arr [待排序数组]
* */
function QuickSort($arr){
    if(!isset($arr[1]))  return $arr;

	//获取一个用于分割的关键字，一般是首个元素
    $mid = $arr[0]; 
    $leftArr = array();
    $rightArr = array();

    foreach($arr as $v){
        if($v > $mid)
        	//把比$mid大的数放到右侧数组里
            $rightArr[] = $v; 
        if($v < $mid)
        	//把比$mid小的数放到左侧数组里
            $leftArr[] = $v; 
    }

	//把左侧数组再一次进行分割
    $leftArr = QuickSort($leftArr); 
    //把分割的元素加到小的数组后面
    $leftArr[] = $mid;
    //把比较大的数组再一次进行分割 
    $rightArr = QuickSort($rightArr); 
	//组合两个结果
    return array_merge($leftArr,$rightArr); 
}

/**
 * 归并排序
 * 归并排序是指将两个或两个以上有序的数列（或有序表），合并成一个仍然有序的数列（或有序表）。
 * 这样的排序方法经常用于多个有序的数据文件归并成一个有序的数据文件。
 * @param [array] $arr [待排序数组]
* */
function MergeSort(&$arr) {
	//求得数组长度
    $len = count($arr);
    mSort($arr, 0, $len-1);
    return $arr;
}

/**
 * 实现归并排序的程序
 * @param  [type] &$arr  [description]
 * @param  [type] $left  [description]
 * @param  [type] $right [description]
 * @return [type]        [description]
 */
function mSort(&$arr, $left, $right) {
    if($left < $right) {
        //说明子序列内存在多余1个的元素，那么需要拆分，分别排序，合并
        //计算拆分的位置，长度/2 去整
        $center = floor(($left+$right) / 2);
        //递归调用对左边进行再次排序：
        mSort($arr, $left, $center);
        //递归调用对右边进行再次排序
        mSort($arr, $center+1, $right);
        //合并排序结果
        mergeArray($arr, $left, $center, $right);
    }
}

/**
 * 将两个有序数组合并成一个有序数组
 * @param  [type] &$arr   [description]
 * @param  [type] $left   [description]
 * @param  [type] $center [description]
 * @param  [type] $right  [description]
 * @return [type]         [description]
 */
function mergeArray(&$arr, $left, $center, $right) {
    //设置两个起始位置标记
    $a_i = $left;
    $b_i = $center+1;
    while($a_i<=$center && $b_i<=$right) {
        //当数组A和数组B都没有越界时
        if($arr[$a_i] < $arr[$b_i]) {
            $temp[] = $arr[$a_i++];
        } else {
            $temp[] = $arr[$b_i++];
        }
    }
    //判断 数组A内的元素是否都用完了，没有的话将其全部插入到C数组内：
    while($a_i <= $center) {
        $temp[] = $arr[$a_i++];
    }
    //判断 数组B内的元素是否都用完了，没有的话将其全部插入到C数组内：
    while($b_i <= $right) {
        $temp[] = $arr[$b_i++];
    }

    //将$arrC内排序好的部分，写入到$arr内：
    for($i=0, $len=count($temp); $i<$len; $i++) {
        $arr[$left+$i] = $temp[$i];
    }
}


//生成3000个元素的随机数组
$a = array_rand(range(1,10000), 3000); 
shuffle($a); //打乱数组的顺序

$t1 = microtime(true);
BubbleSort($a); //冒泡排序
$t2 = microtime(true);
echo "冒泡排序用时：".(($t2-$t1)*1000).'ms'."\n";

$t3 = microtime(true);
SelectSort($a); //选择排序
$t4 = microtime(true);
echo "选择排序用时：".(($t4-$t3)*1000).'ms'."\n";

$t5 = microtime(true);
InsertSort($a); //插入排序
$t6 = microtime(true);
echo "插入排序用时：".(($t6-$t5)*1000).'ms'."\n";

$t7 = microtime(true);
QuickSort($a); //快速排序
$t8 = microtime(true);
echo "快速排序用时：".(($t8-$t7)*1000).'ms'."\n";

$t9 = microtime(true);
sort($a);
$t10 = microtime(true);
echo "sort排序用时：".(($t10-$t9)*1000)."ms"."\n";

$t11 = microtime(true);
MergeSort($a);
$t12 = microtime(true);
echo "归并排序用时：".(($t12-$t11)*1000)."ms";

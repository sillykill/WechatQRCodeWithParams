<?php


$data = array(
    array( 'row_1_col_1', 'row_1_col_2', 'row_1_col_3' ),
    array( 'row_2_col_1', 'row_2_col_2', 'row_2_col_3' ),
    array( 'row_3_col_1', 'row_3_col_2', 'row_3_col_3' ),
);

$filename = "关注数据";


/**
 * @param $filename 输出的文件名
 * @param $data 输出的csv数据，需要数据数据
 */
function outputCSV($filename, $data) {
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$filename}.csv");
    header("Pragma: no-cache");
    header("Expires: 0");

    $outputBuffer = fopen("php://output", 'w');
    foreach($data as $val) {
        foreach ($val as $key => $val2) {
            $val[$key] = iconv('utf-8', 'gbk', $val2);
// CSV的Excel支持GBK编码，一定要转换，否则乱码
        }
        fputcsv($outputBuffer, $val);
    }

    fclose($outputBuffer);
}

//outputCSV($filename,$data);
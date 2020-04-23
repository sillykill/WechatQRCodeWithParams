<?php


class Net
{
    public function do_get($url, $params) {
        $url = "{$url}?" . http_build_query ( $params );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }

    public function do_post($url, $params, $headers) {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }

    // 上传文件 非二进制文件流
    public function upload_file01($url, $params = array(), $upload_file = false) {
        $data = array ();
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
        if ($upload_file) { // 设置上传文件
            $file = new \CURLFile ( $upload_file ['file'], $upload_file ['type'], $upload_file ['name'] );
            $params ['file'] = $file;
        }
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        $data = json_decode ( $result, true );
        return $data;
    }

    // 上传文件，二进制文件流的形式
    public function upload_file02($url, $params, $file_path, $headers) {
        $ch = curl_init ();
        $url = "{$url}?" . http_build_query ( $params ); // 构造url
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
        $file_data = '';
        if ($file_path) { // 设置上传文件
            $fh = fopen ( $file_path, 'r' );
            $file_data = fread ( $fh, filesize ( $file_path ) );
            fclose ( $fh );
        }
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $file_data );
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
}

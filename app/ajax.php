<?php
require_once 'config.php';

$array = array();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    switch ($_POST['call']) {
        case 'kabupaten':
        case 'kecamatan':
        case 'kelurahan':
            $data = $database->prepare('SELECT * FROM '.$_POST['call'].' WHERE '.$_POST['from'].'_id = ? ORDER BY nama');
            $data->execute(array($_POST['id']));

            $array[] = '<option>Pilih</option>';
            foreach ($data as $key => $value) :
                $array[] = '<option value="'.$value->id.'">'.$value->nama.'</option>';
            endforeach;
            break;

        default:
            $array = array();
            break;
    }
}

echo implode('', $array);

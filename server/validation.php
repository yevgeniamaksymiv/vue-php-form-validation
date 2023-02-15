<?php
session_start();

// fixed CORS error -------------------------------
function cors()
{
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        }

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        }

        exit(0);
    }
}
cors();
// -------------------------------------------------------

$dataJSON = file_get_contents('php://input');
$data = json_decode($dataJSON, true);

$title = $data['title'];
$annotation = $data['annotation'];
$content = $data['content'];
$email = $data['email'];
$views = $data['views'];
$date = $data['date'];
$publish_in_index = $data['publish_in_index'];
$category = $data['category'];

$resp = array('error' => false, 'message' => []);

if (empty($title) || mb_strlen($title) < 3 || mb_strlen($title) > 255) {
    $resp['message'][] = 'Enter correct title';
    $resp['error'] = true;
} else {
    $resp['message'][] = '';
    $resp['error'] = false;
}

if (!empty($annotation) && mb_strlen($annotation) > 500) {
    $resp['message'][] = 'The number of character must be less than 500';
    $resp['error'] = true;
} else {
    $resp['message'][] = '';
    $resp['error'] = false;
}

if (!empty($content) && mb_strlen($content) > 30000) {
    $resp['message'][] = 'The number of character must be less than 30000';
    $resp['error'] = true;
} else {
    $resp['message'][] = '';
    $resp['error'] = false;

}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $resp['message'][] = 'Enter correct email';
    $resp['error'] = true;
} else {
    $resp['message'][] = '';
    $resp['error'] = false;

}

if (!preg_match("/^[0-9]*$/", (int) $views) || (int) $views < 0) {
    $resp['message'][] = 'Views must be a number and greater than zero';
    $resp['error'] = true;
} else {
    $resp['message'][] = '';
    $resp['error'] = false;

}

function checkBiggerThanToday($date)
{
    $today = date("Y-m-d");
    if ($date < $today) {
        return true;
    }
}

if (!empty($date)) {
    $dateArr = explode('-', $date);

    if (!checkdate((int) $dateArr[1], (int) $dateArr[2], (int) $dateArr[0])
        || !checkBiggerThanToday($date)) {

        $resp['message'][] = 'Enter correct date';
        $resp['error'] = true;
    } else {
        $resp['message'][] = '';
        $resp['error'] = false;
    }
}

if (!isset($publish_in_index)) {
    $resp['message'][] = 'Check Yes or No';
    $resp['error'] = true;
} else {
    $resp['message'][] = '';
    $resp['error'] = false;
}

if (in_array((int) $category, [1, 2, 3])) {
    var_dump(in_array((int) $category, [1, 2, 3]));
    $resp['message'][] = '';
    $resp['error'] = false;

} else {
    $resp['message'][] = 'Choose category';
    $resp['error'] = true;
}

header("Content-type: application/json");
echo json_encode($resp);
die();

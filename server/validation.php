<?php
session_start();

// fixed CORS error -------------------------------
function cors()
{
    // headers('Content-Type: application/json');

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

header("Content-type: application/json");

$title = $data['title'];
$annotation = $data['annotation'];
$content = $data['content'];
$email = $data['email'];
$views = $data['views'];
$date = $data['date'];
$publish_in_index = $data['publish_in_index'];
$category = $data['category'];
$isValid = $data['isValid'];
$errors = [];

if (empty($title) || mb_strlen($title) < 3 || mb_strlen($title) > 255) {
    $errors[] = 'Enter correct title';
    $isValid = false;
} else {
    $errors[] = '';
    $isValid = true;
}

if (mb_strlen($annotation) > 500) {
    $errors[] = 'The number of character must be less than 500';
    $isValid = false;
} else {
    $errors[] = '';
    $isValid = true;
}

if (mb_strlen($content) > 30000) {
    $errors[] = 'The number of character must be less than 30000';
    $isValid = false;
} else {
    $errors[] = '';
    $isValid = true;
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Enter correct email';
    $isValid = false;
} else {
    $errors[] = '';
    $isValid = true;
}

if (!preg_match("/^[0-9]*$/", (int) $views) || (int) $views < 0) {
    $errors[] = 'Views must be a number and greater than zero';
    $isValid = false;
} else {
    $errors[] = '';
    $isValid = true;
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

        $errors[] = 'Enter correct date';
        $isValid = false;
    } else {
        $errors[] = '';
        $isValid = true;
    }
}

if (!isset($publish_in_index)) {
    $errors[] = 'Check Yes or No';
}

if (in_array((int) $category, [1, 2, 3])) {
    var_dump(in_array((int) $category, [1, 2, 3]));
    $errors[] = '';
    $isValid = true;
} else {
    $errors[] = 'Choose category';
    $isValid = false;
}

if ($isValid === true) {
    session_destroy();
}
var_dump($errors);

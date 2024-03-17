<?php include("common1.html"); ?>
<?php
// temporary array to store user submitted values

$errors_list = array();
$user = array(
    'name' => '',
    'gender' => '',
    'age' => '',
    'personality_type' => '',
    'favorite_os' => '',
    'min_seeking_age' => '',
    'max_seeking_age' => '',
    'seeking_age' => '',
    'user_photo' => ''
);

// to get the user submitted values 

if(isset($_POST['name'])) {
    $user['name'] = $_POST['name'];
}

if(isset($_POST['gender'])) {
    $user['gender'] = urlencode($_POST['gender']);
}

if(isset($_POST['age'])) {
    $user['age'] = urlencode($_POST['age']);
}

if(isset($_POST['personality-type'])) {
    $user['personality_type'] = ($_POST['personality-type']);
}

if(isset($_POST['favorite_os'])) {
    $user['favorite_os'] = ($_POST['favorite_os']);
}

if(isset($_POST['min-seeking-age'])){
    $user['min_seeking_age'] = ($_POST['min-seeking-age']);
}

if(isset($_POST['max-seeking-age'])){
    $user['max_seeking_age'] = ($_POST['max-seeking-age']);
}

if(isset($_POST['seeking'])) {
    foreach ($_POST['seeking'] as $value) {
        $user['seeking_age'] .= $value;
    }
}

// Name field cannot have numbers

if (preg_match("/[0-9]/", $_POST["name"]) === 1) {
    $errors_list[] = "Name cannot have digits";

}

// Name field should have camel casing

$words = explode(" ", $user["name"]);
for ($i = 0; $i < count($words); $i++) {
    if(strcmp(ucfirst($words[$i]),$words[$i]) !== 0) {
        $errors_list[] = "Name should be in camel case(first alphabet capital)";
        break;
    }
}

// Checking if the user is already present in singles.txt file where we store all data. If the user is already present we throw a message saying that

$singles_file = file("singles.txt");
for ($i = 0; $i < count($singles_file); $i++) {
    $singles = explode(",", $singles_file[$i]);
    $singles_nm = $singles[0];
    if ($singles_nm === $user["name"]) {
        $errors_list[] = "User already signed up with this name!";
        break;
    }
}

// get image name
function get_image_name($user_name) {
    $temp = strtolower($user_name);
    return str_replace(" ", "_", $temp);
}

// validation extra feature from extra spec file  - 1

function valid($name, $gender, $age, $personality_type,
                   $favorite_os, $min_age, $max_age, $seeking) {
    return $name && preg_match("/^[MF]$/", $gender)
            && is_numeric($age) && 0 <= $age && $age <= 99
            && preg_match("/^[IE][NS][TF][JP]$/", $personality_type)
            && preg_match("/^(Windows|Mac OS X|Linux)$/", $favorite_os)
            && is_numeric($min_age) && 0 <= $min_age && $min_age <= 99
            && is_numeric($max_age) && 0 <= $max_age && $max_age <= 99
            && $min_age <= $max_age
            && preg_match("/^[MF]{0,2}$/", $seeking);
}

// make sure that no field is empty

if (empty($errors_list) && !valid($user['name'], $user['gender'], $user['age'], $user['personality_type'], $user['favorite_os'],
    $user['min_seeking_age'], $user['max_seeking_age'], $user['seeking'])) {
    $errors_list[] = "Error..Invalid data! Please try again!";
}


// save the image in images folder
// extra validation 2

$target_dir = "/home/ssirnam1/public_html/WP/HW/3/images/";
if (isset($_FILES["fileToUpload"])) {
    $file_name = get_image_name($user['name']) . ".jpg";
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    move_uploaded_file($file_tmp, "images/".$file_name);
}


//If no errors_list present, write the details to the singles.txt
if (empty($errors_list)) {
    $user_details = $user;
    $to_write = implode(",", $user_details);
    file_put_contents("singles.txt", PHP_EOL.$to_write, FILE_APPEND);
?>
    <pre>
        Thank you
        Welcome to NerdLuv, <?= $user["name"] ?>!
        Now <a href="matches.php">log in to see your matches!</a>
    </pre>
<?php
}
else {
?>
    <div class="errors_list">
        Please fix the following errors_list:
        <ul>
<?php
    foreach ($errors_list as $error) {
?>
            <li><?= $error ?> </li>
    <?php } ?>
        </ul>
    </div>
<?php
}
?>
<?php include("common2.html"); ?>
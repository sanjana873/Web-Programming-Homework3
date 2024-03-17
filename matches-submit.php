<?php include("common1.html");

/* To fetch data from singles.txt file*/
$singles_array = file("singles.txt");

/* Find the user who logged in by comparing in singles.txt file */
$user_info_line = '';
for ($i = 0; $i < count($singles_array); $i++) {
    $user_info_line = strstr($singles_array[$i], $_GET["name"]);
    if ($user_info_line !== FALSE) {
        break;
    }
}

$matches = array();
$user_present = false;

// to fetch the image file to display on screen
function get_image($user_name) {
  $temp = str_replace(" ", "_", strtolower($user_name));
  if (is_present($temp . ".jpg")) {
    // shows that the photo is present for this user
    return $temp;
  } else {
    // default photo file
    return "user";
  }
}

function is_present($file_name) {
  $target_file = "images/".$file_name;
  if (file_exists($target_file)) {
    return true;
  }
}

if (!empty($user_info_line)) {
$user_present = true;
// exploding the file is breaking the file
$user_info = explode(",", $user_info_line);

$user_gender = $user_info[1];
$user_age = (int)$user_info[2];
$user_personality = $user_info[3];
$user_os = $user_info[4];
$user_min_seek = (int)$user_info[5];
$user_max_age = (int)$user_info[6];
$user_seeking = $user_info[7];

/* Extra Feature - 3: */
$match_gender = '';
if (strcmp($user_gender, 'M') === 0) {
    $match_gender = 'F';
} else {
    $match_gender = 'M';
}

// go through a loop and then match the logged in user profile with existing profiles in singles.txt file based on certain conditions
?>
<div>
<?php
$is_first = true;
for ($i = 0; $i < count($singles_array); $i++) {
    $other_info_array = explode(",", $singles_array[$i]);
    $other_gender = $other_info_array[1];
    $other_age = (int)$other_info_array[2];
    $other_personality = $other_info_array[3];
    $other_os = $other_info_array[4];
    $other_min_seek = (int)$other_info_array[5];
    $other_max_seek = (int)$other_info_array[6];
    $other_seeking = $other_info_array[7];
    

    //Matching the seeking gender - whether gender is present in the seeking gender of each other
    if (str_contains($user_seeking, $other_gender) && str_contains($other_seeking, $user_gender) 
      && $user_info[0] != $other_info_array[0]) {
      

        //Find similar age requirements
        $user_matches_others_choice = NULL;
        $other_matches_users_choice = NULL;

        if ($other_min_seek <= $user_age && $user_age <= $other_max_seek)
            $user_matches_others_choice = TRUE;

        if($user_min_seek <= $other_age && $other_age <= $user_max_age)
            $other_matches_users_choice = TRUE;

        //Find similar interest in OS
        if($user_matches_others_choice && $other_matches_users_choice){
            
            if (strcmp($user_os, $other_os) === 0) {
                
                //Find similar interest in personality type
                $inRegex = "/[".$user_personality."]/";
                if (preg_match($inRegex, $other_personality) === 1) {
                    $matches[] = $singles_array[$i];
                    
                    if ($is_first) {
?>
        <strong>Matches for <?= $_GET["name"] ?></strong><br>
<?php
                        $is_first = false;
                    }
?>
  <div class="match">
    <?php echo "<img src=images/" . get_image($other_info_array[0]) . ".jpg" . "  alt=\"user_photo\" />"; ?>
      <div>
          <ul>
              <li><p><?= $other_info_array[0] ?></p></li>
              <li><strong>Gender:</strong> <?= $other_gender ?></li>
              <li><strong> Age:</strong> <?= $other_age ?> </li>
              <li><strong> Pesonality Type:</strong> <?= $other_personality ?> </li>
              <li><strong> OS:</strong> <?= $other_os ?></li>
          </ul>
      </div>
  </div>
<?php
                }
            }
        }
    }
}
} 
?>
</div>

<?php
if ($user_present == false) {
  ?>
    <div> No user with the Given name is present. </div>
  <?php
} elseif (count($matches) === 0) {
  ?>
    <div> No match is found. </div>
  <?php
}
include("common2.html"); ?>
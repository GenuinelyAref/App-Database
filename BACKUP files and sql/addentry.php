<?php include("topbit.php");

// Get Genre list from database
$genre_sql="SELECT * FROM `genre` ORDER BY `genre`.`Genre` ASC";
$genre_query=mysqli_query($dbconnect, $genre_sql);
$genre_rs=mysqli_fetch_assoc($genre_query);

// initialise form variables

$app_name = "";
$subtitle = "";
$url = "";
$genreID = "";
$developer = "";
$age = "";
$rating = "";
$rate_count = "";
$cost = "";
$in_app = 1;
$description = "";

$has_errors = "no";

// set up error field colours / visibility (no errors at first)
$app_error = "no-error";
$url_error = "no-error";
$genre_error = "no-error";
$developer_error = "no-error";
$age_error = "no-error";
$rating_error = "no-error";
$rate_count_error = "no-error";
$description_error = "no-error";

$app_field = "form-ok";
$url_field = "form-ok";
$genre_field = "form-ok";
$developer_field = "form-ok";
$age_field = "form-ok";
$cost_field = "form-ok";
$rating_field = "form-ok";
$rate_count_field = "form-ok";
$description_field = "form-ok";

$age_message = "";
$cost_message = "";


// code below execute when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // get values from form
  $app_name = mysqli_real_escape_string($dbconnect, $_POST['app_name']);
  $subtitle = mysqli_real_escape_string($dbconnect, $_POST['subtitle']);
  $url = mysqli_real_escape_string($dbconnect, $_POST['url']);

  $genreID = mysqli_real_escape_string($dbconnect, $_POST['genre']);

  // if genreID is given, record value so it isn't lost if there are errors
  if ($genreID != "") {
    $genreitem_sql = "SELECT * FROM `genre` WHERE `GenreID` = $genreID";
    $genreitem_query = mysqli_query($dbconnect, $genreitem_sql);
    $genreitem_rs = mysqli_fetch_assoc($genreitem_query);

    $genre = $genreitem_rs['Genre'];

  } // end of genre-safekeeping if statement

  $developer = mysqli_real_escape_string($dbconnect, $_POST['developer']);
  $age = mysqli_real_escape_string($dbconnect, $_POST['age']);
  $rating = mysqli_real_escape_string($dbconnect, $_POST['rating']);
  $rate_count = mysqli_real_escape_string($dbconnect, $_POST['rating_count']);
  $cost = mysqli_real_escape_string($dbconnect, $_POST['cost']);
  $in_app = mysqli_real_escape_string($dbconnect, $_POST['in_app']);
  $description = mysqli_real_escape_string($dbconnect, $_POST['description']);

  // error checking will go here...

  // Check App Name is not blank
  if ($app_name == "") {
    $has_errors = "yes";
    $app_error = "error-text";
    $app_field = "form-error";
  }

  // Check URL is valid

  // remove all illegal characters from a url
  $url = filter_var($url, FILTER_SANITIZE_URL);
  if (filter_var($url, FILTER_VALIDATE_URL) == false) {
    $has_errors = "yes";
    $url_error = "error-text";
    $url_field = "form-error";
  }

  // Check Genre is not blank
  if ($genreID == "") {
    $has_errors = "yes";
    $genre_error = "error-text";
    $genre_field = "form-error";
  }

  // Check developer name is not blank
  if ($developer == "") {
    $has_errors = "yes";
    $developer_error = "error-text";
    $developer_field = "form-error";
  }

  // check that age is a whole number. if blank, set to 0
  if ($age == "" || $age == "0") {
    $age = "0";
    $age_message = "The age has been set to 0 (ie: all ages)";
    $age_error = "defaulted";
  }

  // check that age is a number that is more than 0
  elseif (!ctype_digit($age) || $age < 0) {
    $age_message = "Please enter an integer that is 0 or more";
    $has_errors = "yes";
    $age_error = "error-text";
    $age_field = "form-error";
  }

  // Check Age rating is not blank and an number between 0 and 5

  // Check if rating is a decimal between 0 and 5
  if (!is_numeric($rating) || $rating < 0 || $rating > 5) {
    $has_errors = "yes";
    $rating_error = "error-text";
    $rating_field = "form-error";
  }

  // check that rate count is a whole number
  if (!ctype_digit($rate_count) || $rate_count < 1) {
    $has_errors = "yes";
    $rate_count_error = "error-text";
    $rate_count_field = "form-error";
  }

  // check cost is a numer, if it's blank, set it to 0
  if ($cost == "" || $cost == "0") {
    $cost = 0;
    $cost_message = "The price has been set to $0 (ie: free)";
    $cost_error = "defaulted";
  }

  // check that age is a number that is more than 0
  elseif (!is_numeric($cost) || $cost < 0) {
    $cost_message = "Please enter a number that is 0 or more";
    $has_errors = "yes";
    $cost_error = "error-text";
    $cost_field = "form-error";
  }

  // Check description is not blank
  if ($description == "") {
    $has_errors = "yes";
    $description_error = "error-text";
    $description_field = "form-error";
  }

  // if there are no errors...
  if ($has_errors == "no") {

    // go to success page
    header('Location: add_success.php');

    // get developer id if it exits...
    $developer_sql = "SELECT * FROM `developer` WHERE `Developer` LIKE '$developer'";
    $developer_query = mysqli_query($dbconnect, $developer_sql);
    $developer_rs = mysqli_fetch_assoc($developer_query);
    $developer_count = mysqli_num_rows($developer_query);

    // if developer not already in developer table, add them and get new developerID
    if ($developer_count > 0) {
      $developerID = $developer_rs['DeveloperID'];
    }

    else {
      $add_developer_sql = "INSERT INTO `developer` (`DeveloperID`, `Developer`) VALUES (NULL, '$developer');";
      $add_developer_query = mysqli_query($dbconnect, $add_developer_sql);

      // Get developer ID
      $newdeveloper_sql = "SELECT * FROM `developer` WHERE `Developer` LIKE '$developer'";
      $newdeveloper_query = mysqli_query($dbconnect, $newdeveloper_sql);
      $newdeveloper_rs = mysqli_fetch_assoc($newdeveloper_query);

      $developerID = $newdeveloper_rs['DeveloperID'];

    } // end adding developer to developer table

    // add entry to database
    $addentry_sql = "INSERT INTO `game_details` (`ID`, `Name`, `Subtitle`,
      `URL`, `GenreID`, `DeveloperID`, `Age`, `User Rating`, `Rating Count`,
       `Price`, `In App`, `Description`) VALUES (NULL, '$app_name', '$subtitle',
          '$url', '$genreID', '$developerID', '$age', '$rating', '$rate_count',
           '$cost', '$in_app', '$description');";
    $addentry_query = mysqli_query($dbconnect, $addentry_sql);

    // Get ID for next page
    $getid_sql = "SELECT * FROM `game_details` WHERE
    `Name` LIKE '$app_name'
    AND `Subtitle` LIKE '$subtitle'
    AND `URL` LIKE '$url'
    AND `GenreID` = '$genreID'
    AND `DeveloperID` = '$developerID'
    AND `Age` = $age
    AND `User Rating` = '$rating'
    AND `Rating Count` = $rate_count
    AND `Price` = '$cost'
    AND `In App` = '$in_app'
    ";
    $getid_query = mysqli_query($dbconnect, $getid_sql);
    $getid_rs = mysqli_fetch_assoc($getid_query);

    $ID = $getid_rs['ID'];
    $_SESSION['ID']=$ID;

  } // end of 'no errors' if statement

} // end of if statement (executes when button is pushed)

 ?>

        <div class="box main">
            <div class="add-entry">
                <h2>Add an Entry</h2>

                <form method="post" enctype="multipart/form-data"
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                    <!-- App Name (required) -->
                    <div class="<?php echo $app_error; ?>">
                        Please fill in the 'App Name' field
                    </div>
                    <input class="add-field <?php echo $app_field; ?>" type="text" name="app_name"
                    value="<?php echo $app_name; ?>" placeholder="App Name (requied) ..."/>

                    <!-- Subtitle (optional) -->
                    <input class="add-field" type="text" name="subtitle"
                    value="<?php echo $subtitle; ?>" placeholder="Subtitle (optional) ..."/>

                    <!-- URL (required, must start with http://) -->
                    <div class="<?php echo $url_error; ?>">
                        Please provide a valid URL
                    </div>
                    <input class="add-field <?php echo $url_field; ?>" type="text" name="url"
                    value="<?php echo $url; ?>" placeholder="URL (requied) ..."/>

                    <!-- Genre dropdown (required) -->
                    <div class="<?php echo $genre_error; ?>">
                        Please choose a genre
                    </div>
                    <select class="adv <?php echo $genre_field; ?>" name="genre">
                      <!-- first / selected option -->

                      <?php
                      if ($genreID == "") {
                        ?>
                        <option value="" selected>Genre (Choose something) ...
                        </option>
                        <?php
                      }
                      else {
                        ?>
                        <option value="<?php echo $genreID; ?>" selected>
                        <?php echo $genre; ?></option> <?php
                      }
                      ?>

                      <!-- get options from database -->
                      <?php
                      do {
                        ?>
                          <option value="<?php echo $genre_rs['GenreID']; ?>">
                          <?php echo $genre_rs['Genre']; ?></option>
                        <?php
                      } // end genre do loop

                      while ($genre_rs=mysqli_fetch_assoc($genre_query))
                    ?>

                    </select>

                    <!-- Developer name (required)-->
                    <div class="<?php echo $developer_error; ?>">
                        Developer name can't be blank
                    </div>
                    <input class="add-field <?php echo $developer_field; ?>" type="text" name="developer"
                    value="<?php echo $developer; ?>" placeholder="Developer Name (requied) ..."/>

                    <!-- Age (set to 0 if left blank) -->
                    <div class="<?php echo $age_error; ?>">
                        <?php echo $age_message; ?>
                    </div>
                    <input class="add-field <?php echo $age_field; ?>" type="text" name="age"
                    value="<?php echo $age; ?>" placeholder="Suitable for ages (0 for all)"/>

                    <!-- Rating (Number between 0 - 5, 1dp) -->
                    <div class="<?php echo $rating_error; ?>">
                        Rating has to be a value between 0 and 5
                    </div>
                    <div>
                        <input class="add-field <?php echo $rating_field; ?>" type="text" name="rating"
                        value="<?php echo $rating; ?>" step="0.1"
                        min="0" max="5" placeholder="Rating (0-5)"/>
                    </div>

                    <!-- # of ratings (integer more than 0) -->
                    <div class="<?php echo $rate_count_error; ?>">
                        Number of ratings has to be an integer bigger than 0
                    </div>
                    <input class="add-field <?php echo $rate_count_field; ?>" type="text" name="rating_count"
                    value="<?php echo $rate_count; ?>" placeholder="# of Ratings"/>

                    <!-- Cost (decimal 2dp, must be more than 0) -->
                    <div class="<?php echo $cost_error; ?>">
                        <?php echo $cost_message; ?>
                    </div>
                    <input class="add-field <?php echo $cost_field; ?>" type="text" name="cost"
                    value="<?php echo $cost; ?>" placeholder="Cost (number only)"/>

                    <!-- line break -->
                    <br /><br />

                    <!-- In app purchases radio buttons -->
                    <div>
                        <b>In App Purchases: </b>
                        <!-- defaults to 'yes' -->
                        <!-- note: value in database is boolean, so use 1's and 0's -->
                        <?php
                        if ($in_app == 1) {
                          // default to yes (boolean value of 1)
                          ?>
                          <input type="radio" name="in_app" value="1" checked="checked"/> Yes
                          <input type="radio" name="in_app" value="0"/> No
                          <?php
                        } // end in app purchases if statement
                        else {
                          ?>
                          <input type="radio" name="in_app" value="1" /> Yes
                          <input type="radio" name="in_app" value="0" checked="checked"/> No
                          <?php
                        } // end in app purchases else statement
                        ?>

                    </div> <!-- close in-app purchases radio button div -->

                    <!-- line break -->
                    <br />

                    <!-- Description text area -->
                    <div class="<?php echo $description_error; ?>">
                        Please enter a valid description
                    </div>
                    <textarea class="add-field <?php echo $description_field; ?>"
                    name="description" placeholder="Description..." rows="6"></textarea>

                    <!-- Submit button -->
                    <p>
                        <input class="submit advanced-button special_search" type="submit"
                        value="Submit" />
                    </p>
                </form>



            </div> <!-- close add-entry div -->
        </div> <!-- / main -->

<?php include("bottombit.php") ?>

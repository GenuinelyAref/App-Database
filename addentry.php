<?php include("topbit.php");


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
$inapp = 1;
$description = "";

$has_errors = "no";

// code below execute when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo "You pushed the button";
} // end of if statement

 ?>

        <div class="box main">
            <div class="add-entry">
                <h2>Add an Entry</h2>

                <form method="post" enctype="multipart/form-data"
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                    <!-- App Name (required) -->
                    <input class="add-field" type="text" name="app_name"
                    value="<?php echo $app_name; ?>" placeholder="App Name (requied) ..."/>

                    <!-- Subtitle (optional) -->
                    <input class="add-field" type="text" name="subtitle"
                    value="<?php echo $subtitle; ?>" placeholder="Subtitle (optional) ..."/>

                    <!-- URL (required, must start with http://) -->
                    <input class="add-field <?php echo $url_field; ?>" type="text" name="url"
                    value="<?php echo $url; ?>" placeholder="URL (requied) ..."/>

                    <!-- Genre dropdown (required) -->
                    <select class="adv" name="genre">
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
                    <input class="add-field <?php echo $developer_field; ?>" type="text" name="developer"
                    value="<?php echo $developer; ?>" placeholder="Developer Name (requied) ..."/>

                    <!-- Age (set to 0 if left blank) -->
                    <input class="add-field" type="text" name="age"
                    value="<?php echo $age; ?>" placeholder="Suitable for ages (0 for all)"/>

                    <!-- Rating (Number between 0 - 5, 1dp) -->
                    <div>
                        <input class="add-field" type="text" name="rating"
                        value="<?php echo $rating; ?>" step="0.1"
                        min="0" max="5" placeholder="Rating (0-5)"/>
                    </div>

                    <!-- # of ratings (integer more than 0) -->
                    <input class="add-field" type="text" name="rating_count"
                    value="<?php echo $rate_count; ?>" placeholder="# of Ratings"/>

                    <!-- Cost (decimal 2dp, must be more than 0) -->
                    <input class="add-field" type="text" name="cost"
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

<?php include("topbit.php");

      $app_name = mysqli_real_escape_string($dbconnect, $_POST['app_name']);
      $developer = mysqli_real_escape_string($dbconnect, $_POST['dev_name']);
      $genre = mysqli_real_escape_string($dbconnect, $_POST['genre']);
      $cost = mysqli_real_escape_string($dbconnect, $_POST['cost']);

      // Cost (when cost is not specified)
      if ($cost=="") {
        $cost_op = ">=";
        $cost = 0;
      }
      else {
        $cost_op = "<=";
      }

      // In App Purchases
      if (isset($_POST['in_app'])) {
        $in_app = 0;
      }

      else {
        $in_app = 1;
      }

      // User Ratings
      $rating_label = mysqli_real_escape_string($dbconnect, $_POST['rating_label']);
      $rating = mysqli_real_escape_string($dbconnect, $_POST['rating']);

      if ($rating == "") {
        $rating = 0;
        $rating_label = "At least";
      }

      if ($rating_label == "At most") {
          $rate_op = "<=";
      }

      else {
        $rate_op = ">=";
      } // end rating if / elseif / else

      // Age Ratings
      $age_rating_label = mysqli_real_escape_string($dbconnect, $_POST['age_rating_label']);
      $age_rating = mysqli_real_escape_string($dbconnect, $_POST['age_rating']);

      if ($age_rating == "") {
        $age_rating = 0;
        $age_rating_label = "At least";
      }

      if ($age_rating_label == "At most") {
          $age_rate_op = "<=";
      }

      else {
          $age_rate_op = ">=";
      } // end rating if / elseif / else


      $find_sql = "SELECT * FROM `game_details`
      JOIN genre ON (game_details.GenreID = genre.GenreID)
      JOIN developer ON (game_details.DeveloperID = developer.DeveloperID)
      WHERE `Name` LIKE '%$app_name%'
      AND `Developer` LIKE '%$developer%'
      AND `Genre` LIKE '%$genre%'
      AND `Price` $cost_op '%$cost%'
      AND (`In App` = $in_app OR `In App` = 0)
      AND `User Rating` $rate_op $rating
      AND `Age` $age_rate_op $age_rating

      ";
      $find_query = mysqli_query($dbconnect, $find_sql);
      $find_rs = mysqli_fetch_assoc($find_query);
      $count = mysqli_num_rows($find_query);

 ?>

        <div class="box main">
            <h2>Search by App Name / Developer Name</h2>

            <?php include "results.php"; ?>

        </div> <!-- / main -->

<?php include("bottombit.php") ?>

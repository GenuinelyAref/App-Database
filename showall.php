<?php include("topbit.php");

      $find_sql = "SELECT * FROM `game_details`
      JOIN genre ON (game_details.GenreID = genre.GenreID)
      JOIN developer ON (game_details.DeveloperID = developer.DeveloperID)
      ";
      $find_query = mysqli_query($dbconnect, $find_sql);
      $find_rs = mysqli_fetch_assoc($find_query);
      $count = mysqli_num_rows($find_query);

 ?>

        <div class="box main">
            <h2>Welcome</h2>

            <?php

            if ($count < 1) {

            ?>


            <div class="error">
              Sorry! There are no results that match your search. Please use
              the search box in the side bar to try again.
            </div> <!-- end error -->
            <?php
            }
            else {
              do{
                  ?>
                  <!-- Results go here -->
                  <div class="results">

                        <div class="flex-container">
                            <div>
                                <span class="sub_heading">
                                    <!-- Url for each game -->
                                    <a href="<?php echo $find_rs['URL'] ?>">
                                        <!-- Print name of entry -->
                                        <?php echo $find_rs['Name' ] ?>
                                    </a>
                                </span>
                            </div>
                            <?php
                                if ($find_rs['Subtitle']!="")
                                {
                                  ?>
                                  <div>

                                    &nbsp; &nbsp; | &nbsp; &nbsp;
                                    <?php echo $find_rs['Subtitle'] ?>

                                  </div>

                                  <?php
                                }
                                ?>

                        </div> <!-- close flex container div -->

                        <!-- Rating -->
                        <div class="flex-container">
                            <div class="star-ratings-sprite">
                                <span style="width:<?php echo $find_rs['User Rating'] * 20; ?>%" class="star-ratings-sprite-rating">
                                </span>
                            </div>

                            <div class="actual_rating">
                                (<?php echo $find_rs['User Rating'] ?> based on
                                 <?php echo number_format($find_rs['Rating Count']) ?> ratings)
                            </div>
                        </div>

                        <p>
                              <!-- PRICE & In-app purchases -->
                              <b>Price</b>:
                              <?php
                              // if price is equal to zero
                              if ($find_rs['Price'] == 0) {
                                ?>
                                <!-- the app is free & print that information -->
                                Free
                                <?php
                              }
                              // if the app price is not equa to zero
                              else {
                                // print price of the app from the database
                                ?>$<?php echo $find_rs['Price'];
                              } // end else
                              ?>

                              <!-- if there are in-app purchases, print so -->
                              <?php
                              // if boolean is equal to zero, then it's no
                              if ($find_rs['In App'] == 1) {
                                ?> (In-app purchases)<?php
                              }
                               ?>

                             <!-- 2 line breaks -->
                             <br />
                             <br />


                             <!-- print developer name -->
                             <b>Developer</b>:
                             <?php echo $find_rs['Developer'] ?>

                             <!-- line break -->
                             <br />

                            <!-- GENRE -->
                            <b>Genre</b>:
                            <?php echo $find_rs['Genre'] ?>

                            <!-- line break -->
                            <br />

                            <!-- Age rating -->
                            Suitable for ages <?php echo $find_rs['Age'] ?> and up


                            <!-- line break -->
                            <br />


                        </p>
                        <hr /> <!-- horizontal line separator -->
                        <p>
                            <!-- print description of app -->
                            <i><?php echo $find_rs['Description'] ?></i>
                        </p>

                  </div>

                  <br />

                  <?php
                } // end do loop
                while ($find_rs=mysqli_fetch_assoc($find_query));
            } // end else

            ?>



        </div> <!-- / main -->

<?php include("bottombit.php") ?>

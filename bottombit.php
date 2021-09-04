        <div class="box side">

           <h2>Add an App |
              <a class="side" href="showall.php">Show All</a></h2>

           <form class="searchform" method="post"
           action="name_dev.php" enctype="multipart/form-data">
              <input  class="search" type="text" name="dev_name" size="25"
              value="" required placeholder="App Name / Developer Name..."/>

              <input class="submit special_search" type="submit" name="find_game_name"
              value="&#xf002;"/>
           </form>

           <form class="searchform" method="post"
           action="free.php" enctype="multipart/form-data">
              <input class="submit free special_search" type="submit" name="free"
              value="Free with no in-app purchases &nbsp; &#xf002;" />
           </form>


           <br />
           <hr />
           <br />

           <div class="advanced-frame">
              <h2>Advanced Search</h2>

              <form class="searchform" method="post" action="advanced.php"
              enctype="multipart/form-data">
                  <p>Form goes here...</p>

                  <input class="adv" type="text" name="app_name" size="40"
                  value="" placeholder="App Name / Title..."/>

                  <input class="adv" type="text" name="dev_name" size="40"
                  value="" placeholder="Developer..."/>


                  <!-- Genre Dropdown -->
                  <select class="search adv" name="genre">

                      <option disabled value="" selected>Genre...</option>


                      <!-- get options from database -->
                      <?php
                        $genre_sql="SELECT * FROM `genre` ORDER BY `genre`.`Genre` ASC";
                        $genre_query=mysqli_query($dbconnect, $genre_sql);
                        $genre_rs=mysqli_fetch_assoc($genre_query);

                        do {
                          ?>
                            <option value="<?php echo $genre_rs['Genre']; ?>">
                            <?php echo $genre_rs['Genre']; ?></option>
                          <?php
                        } // end genre do loop

                        while ($genre_rs=mysqli_fetch_assoc($genre_query))
                      ?>

                  </select>

                  <!-- Cost -->
                  <div class="flex-container">

                    <div class="adv-text">
                      Cost&nbsp;(less&nbsp;than):
                    </div> <!-- close cost label -->

                    <div>
                      <input class="adv" type="text" name="cost" size="40"
                      value="" placeholder="$..."/>
                    </div> <!-- close input box -->

                  </div> <!-- close cost flex container -->
                  <!-- No In App Purchases -->

                  <!-- Rating -->

                  <!-- Age -->

                  <!-- Search button / submit query -->
                  <input class="submit advanced-button" type="submit"
                  name="advanced" value="Search &nbsp; &#xf002;" />

              </form>

          </div> <!-- advanced fram -->

        </div> <!-- / side bar -->

        <div class="box footer">
            CC GTT 20XX
        </div> <!-- / footer -->


    </div> <!-- / wrapper -->


</body>

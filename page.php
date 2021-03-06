<?php include_once('includes/header.php');?>
<?php
  if (!empty($_GET['cat_link'])) {
    $cid=$_GET['cat_link'];
    
    // category sql
    $csql="SELECT cat_name, cat_detail FROM mycategory WHERE id=$cid";
    $cresult=$db_config->query($csql);
    $cdata=$cresult->fetch_object();
    $cat_name=$cdata->cat_name;
    $CAT_NAME=strtoupper($cat_name);
    $cat_detail=$cdata->cat_detail;
    
  }
?>
    <!-- body contant start -->
  <main class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="text-center">
          <h1 class="text-center mt-5">
            <?php echo $cat_name;?>
          </h1>
          <p class="text-secondary fs-15">
            <?php echo $cat_detail;?>
          </p>
        </div>
        <h5 class="text-muted font-weight-medium mb-3">Latest News</h5>
      </div>
    </div>
      
    <div class="row">
      <div class="col-lg-6  mb-3 mb-sm-2">
        <?php
          $sql="SELECT id, post_title, post_excerpt, post_pic, post_date, updated_at FROM mypost WHERE cat_id=$cid ORDER BY id DESC";
          $result=$db_config->query($sql);
          $data=$result->fetch_object();
        ?>
        <a href="news.php?news-id=<?php echo $data->id ?>" class="text-decoration-none text-dark">
        <div class="position-relative image-hover img-figure">
          <img
            src="post_images/<?php echo $data->post_pic; ?>"
            class="img-fluid img-ql"
            alt="News Image"
          />
          <span class="thumb-title"><?php echo $CAT_NAME; ?></span>
        </div>
          <h1 class="font-weight-600 mt-3">
            <?php echo $data->post_title; ?>
          </h1>
        <p class="fs-15 font-weight-normal">
          <?php echo substr($data-> post_excerpt,0,230).".."; ?>
        </p>
        </a>
      </div>

      <div class="col-lg-6  mb-3 mb-sm-2">
        <div class="row row-cols-1 row-cols-sm-2 g-4">
          <?php
            $sql="SELECT id, post_title, post_excerpt, post_pic, post_date, updated_at FROM mypost WHERE cat_id=$cid ORDER BY id DESC LIMIT 1,4";
            $result=$db_config->query($sql);
            while ($data=$result->fetch_object()) { 
          ?>
          <div class="col mb-sm-2">
            <a href="news.php?news-id=<?php echo $data->id ?>" class="text-decoration-none text-dark">
              <div class="position-relative image-hover img-figure">
                <img
                  src="post_images/<?php echo $data->post_pic; ?>"
                  class="img-fluid img-ql"
                  alt="world-news"
                />
                <span class="thumb-title"><?php echo $CAT_NAME; ?></span>
              </div>
                <h5 class="font-weight-600 mt-3">
                  <?php echo $data->post_title; ?>
                </h5>
              <p class="fs-15 font-weight-normal">
                <?php //echo $data->post_excerpt; ?>
              </p>
            </a>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <!--4th ads -->
    <?php
        $sql="SELECT ad_pic, ad_url FROM myad WHERE ad_pic_oriantation='landscape' ORDER BY id DESC LIMIT 2,1";
        $result=$db_config->query($sql);
        if ($result->num_rows >0) {
          $data=$result->fetch_object();
        echo "<div class='col text-center mb-4'>
          <a href='$data->ad_url' target='_blank'>
            <img src='ad_pic/$data->ad_pic' alt='Advertisement' class='img-fluid w-100'>
          </a>
        </div>";
        }
      ?>
    <!-- Popular News -->
    <div class="row mt-3">
      <div class="col-sm-12">
        <h5 class="text-muted font-weight-medium mb-3">Popular News</h5>
      </div>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php
        $sql="SELECT id, post_title, post_details, post_pic, post_date, updated_at FROM mypost WHERE cat_id=$cid ORDER BY id DESC LIMIT 5,16";
        $result=$db_config->query($sql);
        while ($data=$result->fetch_object()) { 
      ?>
        <div class="col mb-5 mb-sm-2">
          <a href="news.php?news-id=<?php echo $data->id ?>" class="text-decoration-none text-dark">
            <div class="position-relative image-hover img-figure">
              <img
                src="post_images/<?php echo $data->post_pic; ?>"
                class="img-fluid img-ql"
                alt="world-news"
              />
              <span class="thumb-title"><?php echo $CAT_NAME; ?></span>
            </div>
              <h5 class="font-weight-600 mt-3">
                <?php echo $data->post_title; ?>
              </h5>
          </a>
        </div>
      <?php } ?>
    </div>
  </main>
    <!-- footer starting -->
<?php include_once('includes/footer.php');?>
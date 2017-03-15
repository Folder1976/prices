<?php echo $header; ?>

<main class="b-shops_page g-container">
  <!-- Хлебные крошки. START -->
  <div class="b-breadcrumb">
  <?php $count = 0; ?>
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php if ($count == 0) { ?>
      <a href="<?php echo $breadcrumb['href']; ?>" title=""><span class="ic-home"></span><?php echo $breadcrumb['text']; ?></a>
    <?php } else { ?>
      <span>&nbsp;>&nbsp;</span><a href="<?php echo $breadcrumb['href']; ?>" title="<?php echo $breadcrumb['text']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  <?php $count++;} ?>
  </div>
  <!-- Хлебные крошки. END -->

  <div class="b-shops_content">
    <ul>
      <?php foreach($shops as $shop){ ?>
      <li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?><?php echo $language_href; ?><?php echo $shop['href']; ?>"><?php echo $shop['name']; ?></a></li>
      <?php } ?>
    </ul>
  </div>


</main>




  <!--content section-->
  <section class="content-section" style="display: none">
      <div class="inner-block">

          <div class="special-row clearfix">
              <!--sidebar-->
              <section class="sidebar left">

                  <!--category menu-->
                  <nav class="category-menu">
                      <ul>
							<li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?><?php echo $language_href; ?>about">О проекте</a></li>
							<li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?><?php echo $language_href; ?>brands_and_shops">Бренды и магазины</a></li>
							<li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?><?php echo $language_href; ?>user-license">Пользовательское соглашение</a></li>
                      </ul>
                  </nav>
                  <!--end category menu-->

              </section>
              <!--end sidebar-->
         
              
            <!--cont-->
              <section class="cont right">
                  <div class="inner-special-box special">

                      <!--breadcrumbs-->
                      <nav class="breadcrumbs inline mobile-off">
                          <ul class="clearfix">
                              <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                                <?php if($breadcrumb['href'] == ''){ ?>
                                    <li><?php echo $breadcrumb['text']; ?></li>
                                <?php }else{ ?>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?><?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                                <?php } ?>
                              <?php } ?>
                          </ul>
                      </nav>
                      <!--end breadcrumbs-->
                         
                      	<!--alphabet section-->
							<section class="alphabet-section">
								<div class="big-title"><?php echo $heading_title; ?></div>
								<?php echo $description; ?> 
								
								<?php $first_letter = ''; $count_mem = count($shops); $count = ceil($count_mem / 3); ?>
								<div class="alphabet-list clearfix">
									
									<!--div class="letter left">A</div-->
									<div class="column">
										<ul>
											
										<?php foreach($shops as $shop){ ?>
									 
											<li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?><?php echo $language_href; ?><?php echo $shop['href']; ?>"><?php echo $shop['name']; ?></a></li>
										
											<?php
												$count--; 
												if($count < 1){
												$count = ceil($count_mem / 3); ?>
										
													</ul>
												</div>
												<div class="column left">
													<ul>
										
											<?php } ?>
											
											
										<?php } ?>
										</ul>
									</div>
								</div>
							</section>
							<!--end alphabet section-->

                      
                  </div>
              </section>
          </div>

      </div>
  </section>

<?php echo $footer; ?>

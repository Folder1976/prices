<?php echo $header; ?>



  <!--content section-->
  <section class="content-section">
      <div class="inner-block">

          <div class="special-row clearfix">
              <!--sidebar-->
              <section class="sidebar left">

                  <!--category menu-->
                  <nav class="category-menu">
                      <ul>
							<li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?>about">О проекте</a></li>
							<li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?>brands_and_shops">Бренды и магазины</a></li>
							<li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?>user-license">Пользовательское соглашение</a></li>
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
									 
											<li><a href="http://<?php echo $_SERVER['HTTP_HOST'].'/'.TMP_URL; ?><?php echo $shop['href']; ?>"><?php echo $shop['name']; ?></a></li>
										
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

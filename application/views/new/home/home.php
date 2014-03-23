			<h1 id="top-title">Dashboard</h1>
		</div>
		<div id="main">
			<div id="main-container">
				<div id="page-tabs-container">
					
				</div>
				<div class="clear"></div>
				<div id="page-content">
					<div id="home_contests" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<div class="thumbnail">
									<a href="<?=site_url("contests")?>"><img src="assets/theme_new/images/contest_thumb.jpg" /></a>
								</div>
								<h3><a href="<?=site_url("contests")?>">Online Contests</a></h3>
								<p class="all-link"><a href="<?=site_url("contests")?>">You can see previous contests and participate in running contests here!</a></p>

								<div class="clear"></div>
							</div>
						</div>
					</div>
					<div id="home_problemset" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<div class="thumbnail">
									<a href="<?=site_url("sections/view/problemset")?>"><img src="assets/theme_new/images/problemset_thumb.jpg" /></a>
								</div>
								<h3><a href="<?=site_url("sections/view/problemset")?>">Problem Set</a></h3>
								<p class="all-link"><a href="<?=site_url("sections/view/problemset")?>">The archive gathered from past contests held all over the world, mostly suitable for training!</a></p>

								<div class="clear"></div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
					<div id="home_news" class="shadowed">
						<div class="inner-box">
							<div class="content">
								<h3>Latest News</h3>
									<ul>
										<?php for($i=0;$i<count($news);$i++) {
											if($i == 0) { ?>
												<li class="red"><strong><?=$news[$i]->content?></strong></li>		
											<? } else { ?>
												<li><?=$news[$i]->content?></li>
										<? } } ?>
									</ul>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>

        <div class="container demo-1">

            <div id="slider" class="sl-slider-wrapper">

				<div class="sl-slider">
				
					<div class="sl-slide bg-1" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                                            
						<div class="sl-slide-inner">
                                                    <!--<div class="deco" ></div>-->
                                                    
                                                    <img style="width: 100%; height: 100%" src="<?= base_url('assets/images/slider/3.png')?>" />
							<h2></h2>
						</div>
					</div>
					
					<div class="sl-slide bg-2" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
						<div class="sl-slide-inner">
							<img style="width: 100%; height: 100%" src="<?= base_url('assets/images/slider/4.png')?>" />
							<h2></h2>
						</div>
					</div>
					
					<div class="sl-slide bg-3" data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<img style="width: 100%; height: 100%" src="<?= base_url('assets/images/slider/5.png')?>" />
							<h2></h2>
						</div>
					</div>
					
					<div class="sl-slide bg-4" data-orientation="vertical" data-slice1-rotation="-5" data-slice2-rotation="25" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<img style="width: 100%; height: 100%" src="<?= base_url('assets/images/slider/6.png')?>" />
							<!--<h2>Donna nobis pacem</h2>
							<blockquote><p>The human body has no more need for cows' milk than it does for dogs' milk, horses' milk, or giraffes' milk.</p><cite>Michael Klaper M.D.</cite></blockquote>-->
						</div>
					</div>
					
					<div class="sl-slide bg-5" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<img style="width: 100%; height: 100%" src="<?= base_url('assets/images/slider/7.png')?>" />
							<!--<h2>Acta Non Verba</h2>
							<blockquote><p>I think if you want to eat more meat you should kill it yourself and eat it raw so that you are not blinded by the hypocrisy of having it processed for you.</p><cite>Margi Clarke</cite></blockquote>-->
						</div>
					</div>
				</div><!-- /sl-slider -->
				
				<nav id="nav-arrows" class="nav-arrows">
					<span class="nav-arrow-prev">Previous</span>
					<span class="nav-arrow-next">Next</span>
				</nav>

				<nav id="nav-dots" class="nav-dots">
					<span class="nav-dot-current"></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</nav>

			</div><!-- /slider-wrapper -->

        </div>

    <script>

			$(function() {
			
                        
                            function makeClick(){
                                $( this ).on( 'click', function( event ) {

                                        var $dot = $( this );

                                        if( !slitslider.isActive() ) {

                                                $nav.removeClass( 'nav-dot-current' );
                                                $dot.addClass( 'nav-dot-current' );

                                        }

                                        slitslider.jump( i + 1 );
                                        return false;

                                } );                                
                            }                        
                                
                                window.setInterval(
                                function() {
                                                  slitslider.next()
                                                }                        
                                , 5000);
                                
                                var slitslider;
				var Page = (function() {

					var $navArrows = $( '#nav-arrows' );
					var $nav = $( '#nav-dots > span' );
						slitslider = $( '#slider' ).slitslider( {
							onBeforeChange : function( slide, pos ) {

								$nav.removeClass( 'nav-dot-current' );
								$nav.eq( pos ).addClass( 'nav-dot-current' );

							}
						} ),

						init = function() {

							initEvents();
							
						},
						initEvents = function() {                                                    
                                                    
							// add navigation events
							$navArrows.children( ':last' ).on( 'click', function() {

								slitslider.next();
								return false;

							} );

							$navArrows.children( ':first' ).on( 'click', function() {
								
								slitslider.previous();
								return false;

							} );

							$nav.each( function( i ) {							
                                                            makeClick();								
							} );

						};

						return { init : init };

				})();

				Page.init();

				/**
				 * Notes: 
				 * 
				 * example how to add items:
				 */

				/*
				
				var $items  = $('<div class="sl-slide sl-slide-color-2" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"><div class="sl-slide-inner bg-1"><div class="sl-deco" data-icon="t"></div><h2>some text</h2><blockquote><p>bla bla</p><cite>Margi Clarke</cite></blockquote></div></div>');
				
				// call the plugin's add method
				ss.add($items);

				*/
			
			});
		</script>
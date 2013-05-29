		<footer>&copy; <?php echo date('Y'); ?></footer>
	</section>
    
    
    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php bloginfo('template_url');?>/_resources/js/libs/jquery-1.8.3.min.js"><\/script>')</script>
    	
	<script defer src="<?php bloginfo('template_url');?>/js/plugins.js"></script>
	<script defer src="<?php bloginfo('template_url');?>/js/script.js"></script>
		
	<?php wp_footer(); ?>
	
</body>
</html>

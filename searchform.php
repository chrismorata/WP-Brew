<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
    <input type="text" class="field" name="s" id="s"  value="Search the Site" onfocus="if (this.value == 'Search the Site') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search the Site';}" />
    <input type="submit" class="submit" name="submit" value="search" />
</form>

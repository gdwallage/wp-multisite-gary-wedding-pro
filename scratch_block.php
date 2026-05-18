<?php
require_once 'wp-load.php';
$block_content = '<!-- wp:gw/service-grid {"grid_layout":"3-cols"} -->
<div class="wp-block-gw-service-grid"><!-- wp:gw/single-service {"bookly_id":"1"} /-->
<!-- wp:gw/single-service {"bookly_id":"2"} /--></div>
<!-- /wp:gw/service-grid -->';
echo do_blocks($block_content);

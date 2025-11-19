<?php 
require_once __DIR__ . '/../db/config_api.php'; 
?>
<script>
    const BASE_API_URL = "<?php echo BASE_API_URL; ?>";
     const IMAGE_URL = "<?php echo defined('IMAGE_URL') ? IMAGE_URL : BASE_API_URL; ?>";
</script>
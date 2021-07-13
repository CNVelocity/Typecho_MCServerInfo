# Typecho_MCServerInfo
A plugin for Typecho blog to show your Minecraft server information!

Requires MCSManager API.

For default theme you add:

<?php if (!empty($this->options->sidebarBlock) && in_array('MCServerInfo_Plugin', $this->options->sidebarBlock)): ?>
<?php $all = Typecho_Plugin::export();?>
<?php if (array_key_exists('MCServerInfo', $all['activated'])) : ?>
<h3 class="widget-title">服务器信息:</h3>
<?php MCServerInfo_Plugin::render();?>
<?php endif;?>
<?php endif;?>

  To the 'sidebar.php'.

For MSWordStar theme you add:

<?php if ($component == 'MCServerInfo_Plugin'): ?>
<?php $all = Typecho_Plugin::export();?>
<?php if (array_key_exists('MCServerInfo', $all['activated'])) : ?>
<section class="border <?php echo in_array('HideMCServerInfo_Plugin', $sidebarM)?$hideClass:''; ?> <?php echo $rounded; ?>">
<h4>服务器信息:</h4>
<?php MCServerInfo_Plugin::render();?>
<?php endif;?>

  To '\components\sidebar.php'.

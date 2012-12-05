<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<ul>
    <li><a href="?divide=day">每日销量柱状统计图</a></li>
    <li><a href="?divide=month">每月销量柱状统计图</a></li>
</ul>
<?php include smart_view('col.graph') ?>
<div><?php echo $start.'到'.$end; ?></div>

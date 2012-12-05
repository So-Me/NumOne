<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
// my.crumb 面包屑导航
// $controller
// $target

$this_nav = $navs[$controller];

function get_nav_by_link($nav, $link='') // this function here is not so elegent
{
    foreach ($nav as $sub_nav)
        if ($sub_nav['link'] == $link)
            return $sub_nav;
    return false;
}

$sub_nav = get_nav_by_link($this_nav['sub'], $target);
if (isset($sub_nav['name'])) {
    $sub_title = $sub_nav['name'];
} else {
    $sub_nav = get_nav_by_link($this_nav['sub']);
    $sub_title = $sub_nav['name'];
}
?>
<div class="crumb">
    <span><?= $this_nav['title'] ?></span>
    <span>&gt;</span>
    <span><?= $sub_title ?></span>
</div>

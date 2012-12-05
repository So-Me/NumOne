<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?> 
<table>
    <tr>
        <th>工厂名称</th>
        <th>联系人</th>
        <th>联系电话</th>
        <th>QQ</th>
        <th>区域</th>
        <th>成交</th>
        <th>未结清</th>
        <th>剩余辅石</th>
        <th>账户余额</th>
        <th>修改</th>

    </tr>
    <?php foreach ($factories as $factory): ?>
        <tr>
            <td class="name"><?= $factory->name ?></td>
            <td class="contact"><?= $factory->contact ?></td>
            <td class="phone"><?= $factory->phone ?></td>
            <td class="qq"><?= $factory->qq ?></td>
            <td class="city"><?= $factory->city ?></td>
            <td class="done"><?= $factory->done ?></td>
            <td class="undone"><?= $factory->undone ?></td>
            <td class="st_reamain"><a href="<?= ROOT . 'factory/' . $factory->id . '/stone' ?>"><?= $factory->stAccount()->remain() ?></a></td>
            <td><a href="<?= ROOT . 'factory/' . $factory->id . '/account' ?>"><?= $factory->account()->remain() ?></a></td>
            <td class="control">修改</td>
        </tr>
    <?php endforeach ?>
</table>

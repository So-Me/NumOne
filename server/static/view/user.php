<?php
!defined('IN_PTF') && exit('ILLEGAL EXECUTION');
/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */
?>
<div class="search">
    <form action="<?= ROOT ?>user">
        <div class="e">
            <label for="name">客户名：</label>
            <input name="name" id="name" class="" value="<?= $name ?>" />
        </div>
        <div class="e">
            <label for="username">帐&nbsp;&nbsp;号：</label>
            <input name="username" id="username" class="" value="<?= $username ?>" />
        </div>
        <div class="e user-login-num">
            <label for="">登录次数：</label>
            <?= $user->loginTimes() ?>
        </div>
        <div class="e order-time">
            <label for="time_start">下单时间：</label>
            <input type="text" name="time_start" id="time_start" value="<?= $time_start ?>" />&nbsp;-&nbsp;<input type="text" name="time_end" id="time_end" value="<?= $time_end ?>" />
        </div>
    	<div class="e">
            <label for="">状态：</label>
            <?php
            $field_name = 'state';
            $data = $customer_states;
            include smart_view('widget.select');
            ?>
        </div>
        <input class="e mbtn" type="submit" value="搜索" />
    </form>

    <div class="search-result">
    	<?php include smart_view('paging'); ?>
    	<span>共找到<?= $total ?>条</span>
	</div>
</div>

<div class="table-whole">
<div class="table-th">
    <span class="col title">&nbsp;帐号</span>
    <span class="col title">&nbsp;客户名</span>
    <span class="col title sex">&nbsp;性别</span>
    <span class="col title phone">&nbsp;电话</span>
    <span class="col title qq">&nbsp;QQ</span>
    <span class="col title">&nbsp;区域</span>
    <span class="col title">&nbsp;登录</span>
    <span class="col title">&nbsp;成交</span>
    <span class="col title">&nbsp;未结清</span>
    <span class="col title account">&nbsp;账户余额</span>
    <span class="col title">&nbsp;状态</span>
    <span class="col title">修改</span>
</div>
<?php foreach ($customers as $cus):  ?>
    <?php $user_ = $cus->user(); $account = $cus->account(); ?>
    <div class="table-row">
        <div class="entry" data-id="<?= $cus->id ?>">
            <div class="col ">&nbsp;<?= $user_->name ?></div>
            <div class="col ">&nbsp;<?= $user_->realname ?></div>
            <div class="col sex">&nbsp;<?= $cus->gender ?></div>
            <div class="col phone">&nbsp;<?= $user_->phone ?></div>
            <div class="col qq">&nbsp;<?= $cus->qq ?></div>
            <div class="col ">&nbsp;<?= $cus->city ?></div>
            <div class="col ">&nbsp;<?= $user_->loginTimes() ?></div>
            <div class="col ">&nbsp;<?= $cus->dealTimes() ?></div>
            <div class="col ">&nbsp;<?= $cus->undoneTimes() ?></div>
            <div class="col account">&nbsp;<a href="<?= ROOT . 'user/' . $cus->id . '/account' ?>"><?= $account->remain ?></a></div>
            <div class="col ">&nbsp;<?= $customer_states[$cus->state] ?></div>
            <div class="col edit"><span class="edit-btn">修改</span></div>
        </div>
        <div class="more-info">
            <table class="login-info">
                <tr>
                    <td>注册信息</td>
                    <td><?= $user_->create_time ?></td>
                </tr>
                <tr>
                    <td>登录历史</td>
                    <td>
                        <?php foreach ($user_->loginHistory() as $entry): ?>
                            <div><?= $entry['time'] ?> <?= $entry['ip'] ?></div>
                        <?php endforeach ?>
                    </td>
                </tr>
            </table>
            <table class="detail-info">
                <tr>
                    <td>用户姓名</td><td><?= $user->realname ?></td>
                </tr>
                <tr>
                    <td>账户余额</td><td><?= $account->remain ?></td>
                </tr>
                <tr>
                    <td>成交金额</td><td><?= $account->done ?></td>
                </tr>
                <tr>
                    <td>未结清金额</td><td><?= $account->undone ?></td>
                </tr>
                <tr>
                    <td>成交次数</td><td><?= $cus->dealTimes() ?></td>
                </tr>
                <tr>
                    <td>下单次数</td><td><?= $cus->orderTimes() ?></td>
                </tr>
                <tr>
                    <td>邮箱</td><td><?= $user->email ?></td>
                </tr>
                <tr>
                    <td>地址</td><td><?= $cus->defaultAddress()->detail ?></td>
                </tr>
                <tr>
                    <td>用户备注</td><td><?= $cus->remark ?></td>
                </tr>
            </table>
            <br class="clear-fix">
        </div>
    </div>
<?php endforeach; ?>
</table>
</div>

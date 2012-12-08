<?php
!defined('IN_APP') && exit('ILLEGAL EXECUTION');

if (!file_exists(AppFile::controller("api.get.$kind"))) {
    exit("not right kind: $kind"); // TODO
}

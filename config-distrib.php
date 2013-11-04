<?php

# This is your default configuration file

# TODO:
# [ ] - create config-distrib.php and add it to your Version Control
# [ ] - keep both files synced up in your project

# atk/base_path is a root location of a toolkit. Defaults to 'amodules3'
$config['atk']['base_path']='./atk4/';

# your database access, if you use $api->dbConnect();
$config['dsn']='mysql://root:root@localhost/project';

$config['locale']['datetime'] = 'm/d/Y H:i';
$config['locale']['date'] = 'm/d/Y';
$config['locale']['date_js'] = 'mm/dd/yy';

# Agile Toolkit attempts to use as many default values for config file,
# and you only need to add them here if you wish to re-define default
# values. For more options look at:
#
#  http://www.atk4.com/doc/config


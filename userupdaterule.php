<?php

$uids = db_query('SELECT uid FROM {users}  WHERE uid < 1000 ORDER BY uid DESC LIMIT 1000 ')->fetchCol();
echo "\n ";   
$users = user_load_multiple($uids);
foreach ($users as $user) {
	unset($p);
	unset($profile);
  	echo "\n "; 
    $p = profile2_load_by_user($user, $type_name = 'mediacommonsprofile');
 	if (empty( $p) ) {
		echo "p is empty "; 
		echo "no profile " . $user->name;
		$profile = profile2_create(array('type' => 'mediacommonsprofile', 'uid' => $user->uid));
		$profile->field_full_name['und'][0]['value'] = $user->name;
		$profile->save();
		echo "just saved  ";
	} else {
	echo "yes has profile " . $user->name;
	}
}

?>
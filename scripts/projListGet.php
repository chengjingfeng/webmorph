<?php

// get a user's authorised projects

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/main_func.php';
auth();

$user = $_SESSION['user_id'];
$q = new myQuery("SELECT id, project.user_id, name, notes, perm, filemtime, files, size FROM project
                        LEFT JOIN project_user ON project.id=project_id 
                        WHERE project_user.user_id='$user'");
$return['projects'] = $q->get_assoc();
$_SESSION['projects'] = $q->get_one_col('id');

foreach ($return['projects'] as $i => $proj) {
    $q = new myQuery("SELECT user.id, firstname, lastname, email, project_user.perm
                    FROM project_user 
                    LEFT JOIN user ON user.id=user_id 
                    LEFT JOIN project ON project.id=project_id
                    WHERE project_id={$proj['id']}
                    ORDER BY project.user_id!=user.id, lastname, firstname");
    $return['projects'][$i]['owners'] = $q->get_assoc();
}

$q = new myQuery("SELECT id, firstname, lastname, email FROM user");
$return['users'] = $q->get_by_id('id');

function countFilesOO($dir) {
    if (!is_dir($dir)) return false;
    
    /*
    $Directory=new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
    $Iterator = new RecursiveIteratorIterator($Directory);
    $TrashRegex = new RegexIterator($Iterator, '/\/\.trash\//', RecursiveRegexIterator::GET_MATCH);
    $trash = iterator_count($TrashRegex);
    $TmpRegex = new RegexIterator($Iterator, '/\/\.tmp\//', RecursiveRegexIterator::GET_MATCH);
    $tmp = iterator_count($TmpRegex);
    $files = iterator_count($Iterator);
    //foreach ($Iterator as $filename=>$cur) {
    //    $size += $cur->getSize();
    //}
    */
    //$files = exec('find ' . $dir . ' -type f -print | wc -l');
    //$tmp = exec('find ' . $dir . '/.tmp -type f -print | wc -l');
    //$trash = exec('find ' . $dir . '/.trash -type f -print | wc -l');
    //$size = exec('du -sm ' . $dir) * 1024 * 1024;
    
    return array('size' => $size, 'files' => $files, 'trash' => $trash, 'tmp' => $tmp);
}

function countFilesProc($dir) {
    $ret = array();
    $odir = opendir($dir);
    while(($currentFile = readdir($odir)) !== false) {
        if ( $currentFile == '.' or $currentFile == '..' ) {
            continue;
        } else if (is_dir($dir . '/' . $currentFile)) {
            $ret2 = countFilesProc($dir . '/' . $currentFile);
            $ret['files'] += $ret2['files'];
            $ret['size'] += $ret2['size'];
        } else {
            $ret['files']++;
            $ret['size'] += filesize($dir . '/' . $currentFile);
        }
    }
    closedir($odir);
    return $ret;
}


$total_size = 0;
foreach($return['projects'] as $i => $proj) {
/*
    $st = microtime(true);
    $res = countFilesOO(IMAGEBASEDIR . $proj['id']);
    if ($proj['user_id'] == $user) {
        $mysize += $res['size'];
    }
    if ($res) {
        $return['projects'][$i]['filemtime'] = filemtime(IMAGEBASEDIR . $proj['id']);
        $return['projects'][$i]['files'] = $res['files'] | 0;
        $return['projects'][$i]['trash'] = $res['trash'] | 0;
        $return['projects'][$i]['tmp'] = $res['tmp'] | 0;
        $return['projects'][$i]['size'] = formatBytes($res['size']);
    }
    $return['time']['proj' . $proj['id']] = microtime(true) - $st;
*/
    
    $filemtime = filemtime(IMAGEBASEDIR . $proj['id']);
    
    if ($filemtime == $proj['filemtime']) {
        // no changes since last file update
        if ($proj['user_id'] == $user) {
            $mysize += $proj['size'];
        }
        $return['projects'][$i]['files'] = $proj['files'] | 0;
        $return['projects'][$i]['trash'] = $proj['trash'] | 0;
        $return['projects'][$i]['tmp'] = $proj['tmp'] | 0;
        $return['projects'][$i]['size'] = formatBytes($proj['size']);
        $return['projects'][$i]['mysize'] = ($proj['user_id'] == $user) ? $proj['size'] : 0;
    } else {
        unset($return['projects'][$i]['files']);
        unset($return['projects'][$i]['trash']);
        unset($return['projects'][$i]['tmp']);
        unset($return['projects'][$i]['size']);
    }

}

//$return['userAllocation'] = userAllocation($user);

$q = new myQuery("SELECT allocation FROM user WHERE id='$user'");
$allocation = $q->get_one(0, 'allocation');

$return['userAllocation'] = array(
    'allocation' => $allocation,
    'size' => $mysize / 1024 / 1024
);

scriptReturn($return);

exit;

?>
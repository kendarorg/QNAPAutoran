<?php
require_once("settings.php");


?>
<html>
<body>
<table>
    <th><td>command</td><td>result</td></th>
    <tr><td>findUserid</td><td><?php

            $uid = findUserId();
            var_dump($uid);
            ?></td>
    </tr><tr><td>getSid(findUserId()['uid'])</td><td><?php
            echo getSid(findUserId()['uid']);
            ?></td></tr>
    </tr><tr><td>isAdmin(findUserId())</td><td><?php
            echo isAdmin(findUserId());
            ?></td></tr>
    </tr><tr><td>getTempPath()</td><td><?php
            echo getTempPath();
            ?></td></tr>
    </tr><tr><td>getServerUrl()</td><td><?php
            echo getServerUrl();
            ?></td></tr>
    </tr><tr><td>phpversion()</td><td><?php
            echo phpversion();
            ?></td></tr>
</table>


<?php

?>
<pre>
</pre>
</body>
</html>

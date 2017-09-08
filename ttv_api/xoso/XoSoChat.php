<?php

?>
<html>
    <head id="ctl00_Head1"><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="Content-Language" content="vi" />
    </head>
    <body>
        Post Chat<br>
        <ul>
            <form action="http://kenhkiemtien.com/kkt_api/xoso/XoSoAPI.php?action=postChat" method="post" >
                <li>
                    Miền: <select name="region" >
                        <option value="0">All</option>
                        <option value="1">Miền Bắc</option>
                        <option value="2">Miền Trung</option>
                        <option value="3">Miền Nam</option>
                    </select>
                </li>
                <li>
                    User_ID:
                    <select name="user_id" >
                        <option value="22532">Mai Anh</option>
                        <option value="22532">Mai Anh</option>
                        <option value="22532">Mai Anh</option>
                        <option value="22532">Mai Anh</option>
                    </select>
                </li>
                <li>
                    Content: <textarea name="content" rows="20" cols="50" ></textarea> <br>
                </li>
                <li>
                    DeviceName: <input type="text" name="deviceName" value="IOS" /> <br>
                </li>
                <li>
                    <input type="submit" value="Save">
                </li>
            </form>
        </ul>
    </body>
</html>

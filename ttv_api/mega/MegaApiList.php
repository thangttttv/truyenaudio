<style> li {
        padding-top: 10px;
        list-style-type: decimal;
    }

    table, td, th {
        border: 1px solid black;
    }

    a:link {
        text-decoration: none;
    }

    a:visited {
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    a:active {
        text-decoration: underline
    }</style>
<?php require_once("Config.php"); ?>
<H1>Danh sách API Xổ Số Mega645:</H1>
<table style='border: 1px solid black;border-collapse: collapse;'>
    <tr>
        <td>
            <UL>
                <li><a href='<?=Config::$api_url?>?function=getLastResult645' target='_blank'>Kết quả Xs mega 645 mới nhất </a></li>
                <li><a href='<?=Config::$api_url?>?function=getLastResultMax4d' target='_blank'>Kết quả Xs mega Max4d mới nhất </a></li>
                <li><a href='<?=Config::$api_url?>?function=getResultHistory645' target='_blank'>Lấy lịch sử xổ số mage645 </a></li>
                <li><a href='<?=Config::$api_url?>?function=getResultHistoryMax4d' target='_blank'>Lấy lịch sử xổ số Max4d </a></li>
                <li><a href='<?=Config::$api_url?>?function=getStatisticNumber' target='_blank'>Lấy thống kê số lần về các số mega645</a></li>
            </UL>
        </td>
    </tr>
</table>
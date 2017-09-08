<?php

	date_default_timezone_set('Asia/Saigon'); 
    require_once("MegaDAO.php");
    $output = array();
    $action = isset($_GET['action']) ?$_GET['action'] :"" ;
    if(!empty($action)) {
        switch ($action) {
            case "getLastResult645" : {
                $result = getLastResult645();
                echo json_encode($result);
                break;
            }
            case "getLastResultMax4d" : {
                $result = getLastResultMax4d();
                echo json_encode($result);
                break;
            }
            case "getResultHistory645" : {
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $number_per_page = 10;
                $output = array();
                list($result,$max_page) = getResultHistory645($page, $number_per_page);
                $output['result'] = $result;
                $output['max_page'] = $max_page;
                echo json_encode($output);
                break;
            }
            case "getResultHistoryMax4d" : {
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                $number_per_page = 10;
                $output = array();
                list($result,$max_page) = getResultHistoryMax4d($page, $number_per_page);
                $output['result'] = $result;
                $output['max_page'] = $max_page;
                echo json_encode($output);
                break;
            }
            case "getStatisticNumber" : {
                $result = getStatisticNumber645();
                echo json_encode($result);
                break;
            }
        }
    }
?>
<?php
    require_once("Config.php");
    if(isset($_GET['function'])&& !empty($_GET['function'])){
            switch($_GET['function']){
                case "getLastResult645" : {
                    echo "
                        <h1".">Function: register</h1><i>Lấy kết quả Mega 645 mới nhất</i><h3>Danh sách tham số:</h3>
                        <UL>
                            <LI>action: getLastResult645</LI>
                        </UL>
                        <span>Ví dụ: <a href='".Config::$api_url."?action=getLastResult645' target='_blank'>getLastResult645</a></span>";break;
                }
                case "getLastResultMax4d" : {
                    echo "
                        <h1".">Function: getLastResultMax4d</h1><i>Lấy kết quả Mega Max4d mới nhất </i><h3>Danh sách tham số:</h3>
                        <UL>
                            <LI>action: getLastResultMax4d</LI>
                        </UL>
                        <span>Ví dụ: <a href='".Config::$api_url."?action=getLastResultMax4d' target='_blank'>getLastResultMax4d</a></span>";break;
                }
                case "getResultHistory645" : {
                    echo "
                        <h1".">Function: getResultHistory645</h1><i>Lấy lịch sử xổ số Mega645</i><h3>Danh sách tham số:</h3>
                        <UL>
                            <LI>action: getResultHistory645</LI>
                            <LI>method: GET</LI>
                            <LI>Tham số:<br/>
                                page: trang muốn lấy kq<br/>
                            </LI>
                        </UL>
                        <span>Ví dụ: <a href='".Config::$api_url."?action=getResultHistory645&page=1' target='_blank'>getResultHistory645</a></span>";break;
                }
                case "getResultHistoryMax4d" : {
                    echo "
                        <h1".">Function: getResultHistoryMax4d</h1><i>Lấy lịch sử xổ số Mega Max4d</i><h3>Danh sách tham số:</h3>
                        <UL>
                            <LI>action: getResultHistoryMax4d</LI>
                            <LI>method: GET</LI>
                            <LI>Tham số:<br/>
                                page: trang muốn lấy kq<br/>
                            </LI>
                        </UL>
                        <span>Ví dụ: <a href='".Config::$api_url."?action=getResultHistoryMax4d&page=1' target='_blank'>getResultHistoryMax4d</a></span>";break;
                }
                case "getStatisticNumber" : {
                    echo "
                        <h1".">Function: getStatisticNumber</h1><i>Lấy thống kê số lần về các của các số Mega645</i><h3>Danh sách tham số:</h3>
                        <UL>
                            <LI>action: getStatisNumber</LI>

                        </UL>
                        <span>Ví dụ: <a href='".Config::$api_url."?action=getStatisticNumber' target='_blank'>getStatisticNumber</a></span>";break;
                }
            }
    }
?>

